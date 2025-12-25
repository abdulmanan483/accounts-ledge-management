<?php

namespace App\Services;

use App\Helpers\GoogleDriveHelper;
use Exception;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Google\Service\Drive;
use Illuminate\Support\Facades\Storage;

class GoogleSheetsService
{
    public $client, $service, $driveService, $documentId, $range;

    public function __construct()
    {
        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        $this->driveService = new Drive($this->client);
        $this->documentId = '1SSzDYVNVN6XTEccD6csqAmRO561W_mv6pIB4BgpXzsM';
        $this->range = 'A:Z';
    }

    public function getClient()
    {
        $client = new Client();
        $client->setApplicationName('Google Sheets Demo');
        $client->setScopes([Sheets::SPREADSHEETS_READONLY]);
        $client->setAuthConfig(public_path('credentials.json'));
        $client->setAccessType('offline');
        return $client;
    }

    public function readSheet()
    {
        $doc = $this->service->spreadsheets_values->get($this->documentId, $this->range);
        $values = $doc->values;
        return $values;
    }
}
