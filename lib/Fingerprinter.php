<?php

namespace Pex;

class Fingerprinter
{
    public function fingerprintFile(string $input, array $ftType = []): Fingerprint
    {
        $defer = new Defer();

        Lib::get()->Pex_Lock();
        $defer->add(Lib::get()->Pex_Unlock);

        $buffer = Lib::get()->Pex_Buffer_New();
        Error::checkMemory($buffer);
        $defer->add(fn () => Lib::get()->Pex_Buffer_Delete(\FFI::addr($buffer)));

        $status = Lib::get()->Pex_Status_New();
        Error::checkMemory($status);
        $defer->add(fn () => Lib::get()->Pex_Status_Delete(\FFI::addr($status)));

        Lib::get()->Pex_Fingerprint_File($input, $buffer, $status, $this->convertTypes($ftType));
        Error::checkStatus($status);

        return new Fingerprint(\FFI::string(
            Lib::get()->Pex_Buffer_GetData($buffer),
            Lib::get()->Pex_Buffer_GetSize($buffer),
        ));
    }

    public function fingerprintBuffer(string $input, array $ftType = []): Fingerprint
    {
        $defer = new Defer();

        Lib::get()->Pex_Lock();
        $defer->add(Lib::get()->Pex_Unlock);

        $inputBuffer = Lib::get()->Pex_Buffer_New();
        Error::checkMemory($inputBuffer);
        $defer->add(fn () => Lib::get()->Pex_Buffer_Delete(\FFI::addr($inputBuffer)));

        $outputBuffer = Lib::get()->Pex_Buffer_New();
        Error::checkMemory($outputBuffer);
        $defer->add(fn () => Lib::get()->Pex_Buffer_Delete(\FFI::addr($outputBuffer)));

        $status = Lib::get()->Pex_Status_New();
        Error::checkMemory($status);
        $defer->add(fn () => Lib::get()->Pex_Status_Delete(\FFI::addr($status)));

        Lib::get()->Pex_Buffer_Set($inputBuffer, sizeof($inputBuffer));

        Lib::get()->Pex_Fingerprint_Buffer($inputBuffer, $outputBuffer, $status, $this->convertTypes($ftType));
        Error::checkStatus($status);

        return new Fingerprint(\FFI::string(
            Lib::get()->Pex_Buffer_GetData($outputBuffer),
            Lib::get()->Pex_Buffer_GetSize($outputBuffer),
        ));
    }

    private function convertTypes(array $ftTypes): int
    {
        if (!$ftTypes) {
            return FingerprintType::Audio | FingerprintType::Melody;
        }

        $val = 0;
        foreach ($ftTypes as $t) {
            $val |= $t;
        }
        return $val;
    }
}
