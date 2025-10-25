<?php

namespace App\MessageHandler;

use App\Entity\Import;
use App\Manager\ImportManager;
use App\Message\StartImport;
use SimplePie\SimplePie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class StartImportHandler
{
    public function __construct(private EntityManagerInterface $em, private ImportManager $importManager, private SimplePie $simplePie)
    {
    }

    public function __invoke(StartImport $message): void
    {
        $importId = $message->id;
        $import = $this->em->getRepository(Import::class)->find($importId);
        $next = $message->next;
        if ($next !== null) {
            $import->setSourcePath($next);
        }

        $this->importManager->processImport($import);
        return;
        $normalizedEvents = []; // Logic to fetch and normalize data goes here
        $next = null;
        libxml_use_internal_errors(true);
        $this->simplePie->set_feed_url($import->getSourcePath());
        dump($import->getSourcePath());
        $this->simplePie->set_curl_options(array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false));
        dump($this->simplePie->init());
        libxml_clear_errors();
        dump($this->simplePie->error());
        foreach ($this->simplePie->get_items() as $item) {
            
        }
    }

    
}
