<?php
namespace App\Manager;

use App\Entity\Import;
use App\Message\StartImport;
use Doctrine\ORM\EntityManagerInterface;
use SimplePie\SimplePie;
use Symfony\Component\Messenger\MessageBusInterface;

class ImportManager
{
    private $followLink = null;

    public function __construct(
        private EntityManagerInterface $entityManager, 
        private MessageBusInterface $messageBus,
        private SimplePie $simplePie,
    )
    {
    }
    
    public function triggerImports(): void
    {
        $activeImports = $this->entityManager->getRepository(Import::class)->findAllActiveImports();
        foreach ($activeImports as $import) {
            dump("Triggering import ID: " . $import->getId());
            $this->messageBus->dispatch(new StartImport($import->getId()));
        }
        // Logic to trigger import processes
    }

    public function processImport(Import $import): void
    {

        $data = $this->denormalizeData($import);
        $entities = $this->importEntities($import, $data);
    }

    private function denormalizeData(Import $import): array
    {
        $denormalizedData = []; // Logic to denormalize data goes here
        dump($import->getType()->value);
        switch($import->getType()->value) {
            case 'rss':
                // Process RSS feed
                break;
            case 'json':
                // Process JSON feed
                break;
            // Add more cases as needed
            case 'api':
                // Process API feed
                break;
            case 'feed':
                libxml_use_internal_errors(true);
                dump($import->getSourcePath());
                $this->simplePie->set_feed_url($import->getSourcePath());
                $this->simplePie->set_curl_options(array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false));
                libxml_clear_errors();
                if($this->simplePie->error()) {
                    dump("SimplePie Error: " . $this->simplePie->error());
                }
                dump($this->simplePie->error());

                foreach ($this->simplePie->get_items() as $item) {
                    dump("Processing SimplePie item");
                    $temp = [];
                    foreach($item as $key => $value) {
                        $temp[$key] = $value;   
                    }
                    $denormalizedData[] = $temp;
                }
                break;
        }
        return $denormalizedData;
    }
    
    private function importEntities(Import $import, array $data): array
    {
        $transformationRules = $import->getConversionTable();
        foreach($data as $record) {
            $entityData = [];
            foreach ($transformationRules as $field => $rule) {
                if (isset($record[$rule])) {
                    $entityData[$field] = $record[$rule];
                }
            }
            // Here you would typically create and persist the entity using $entityData
        }

        $importedEntities = []; // Logic to import entities goes here
        return $importedEntities;
    }


}