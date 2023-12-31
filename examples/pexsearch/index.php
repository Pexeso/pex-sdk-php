<?php

require __DIR__ . '/vendor/autoload.php';

const CLIENT_ID = "#YOUR_CLIENT_ID_HERE";
const CLIENT_SECRET = "#YOUR_CLIENT_SECRET_HERE";
const INPUT_FILE = "/path/to/file.mp3";

// Initialize and authenticate the client.
$client = new Pex\PexSearchClient(CLIENT_ID, CLIENT_SECRET);

// Optionally mock the client. If a client is mocked, it will only communicate
// with the local mockserver instead of production servers. This is useful for
// testing.
$client->mock();

// Fingerprint a file. You can also fingerprint a buffer with
//
//   client.FingerprintBuffer([]byte).
//
// Both the files and the memory buffers
// must be valid media content in following formats:
//
//   Audio: aac
//   Video: h264, h265
//
// Keep in mind that generating a fingerprint is CPU bound operation and
// might consume a significant amount of your CPU time.
$ft = $client->fingerprintFile(INPUT_FILE);

// You can also specify a type of fingerprint you want to generate.
$ft = $client->fingerprintFile(INPUT_FILE, [Pex\FingerprintType::Audio]);

// Build the request.
$req = new \Pex\PexSearchRequest($ft);

// Start the search.
$fut = $client->startSearch($req);

// Retrieve the result.
$res = $fut->get();

// Print the result.
var_dump($res);
