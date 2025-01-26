<?php

require __DIR__ . '/vendor/autoload.php';

const CLIENT_ID = "#YOUR_CLIENT_ID_HERE";
const CLIENT_SECRET = "#YOUR_CLIENT_SECRET_HERE";
const INPUT_FILE = "/path/to/file.mp3";

// Initialize and authenticate the client.
$client = new Pex\PrivateSearchClient(CLIENT_ID, CLIENT_SECRET);

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

// Ingest it into your private catalog.
$client->ingest("my_id_1", $ft);

// Build the request.
$req = new \Pex\PrivateSearchRequest($ft);

// Start the search.
$fut = $client->startSearch($req);

// Retrieve the result.
$res = $fut->get();

// Print the result.
var_dump($res);
