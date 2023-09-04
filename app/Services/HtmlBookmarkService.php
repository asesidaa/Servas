<?php

namespace App\Services;

use App\Models\User;
use DOMDocument;
use Illuminate\Support\Facades\Storage;

class HtmlBookmarkService
{
    public function test()
    {
        $html = Storage::get('import.html');

        $doc = new DOMDocument();

        $parsedHtml = $doc->loadHTML($html, LIBXML_NOERROR);

        $links = [];

        foreach ($doc->getElementsByTagName('a') as $link) {
            $links['links'][] = [
                'title' => $link->textContent,
                'link' => $link->attributes->getNamedItem('href')->textContent,
                'createdAt' => \DateTime::createFromFormat('U', $link->attributes->getNamedItem('add_date')->textContent)->format('Y-m-d'),
            ];
        }

        $importService = new ImportService();

        $importService->importUserData($links, ['links'], User::find(1));
    }
}
