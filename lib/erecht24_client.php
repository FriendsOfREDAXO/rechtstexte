<?php
declare(strict_types=1);

class rex_erecht24_client 
{
    public const PLUGIN_KEY = 'ML7mWFmozzpDNDbUtYUM7UghXCsi37nWumSrMAk3Y4nCihQQZK7H7LJ9ufx4fyJu'; 
    
    public static function register(string $domain, string $apiKey): bool
    {
        try {
            // Initialize API handler
            $apiHandler = new eRecht24\RechtstexteSDK\ApiHandler($apiKey, self::PLUGIN_KEY);

            // Create new client
            $client = (new eRecht24\RechtstexteSDK\Model\Client())
                ->setPushUri(self::buildPushUrl())        
                ->setPushMethod('POST')                     
                ->setCms('REDAXO')                       
                ->setCmsVersion(rex::getVersion())
                ->setPluginName('redaxo/erecht24')
                ->setAuthorMail(rex::getErrorEmail());

            // Register client with eRecht24
            $registeredClient = $apiHandler->createClient($client);

            if (!$apiHandler->isLastResponseSuccess()) {
                throw new rex_exception('Failed to register client: ' . $apiHandler->getLastErrorMessage());
            }

            // Store client information in database
            $sql = rex_sql::factory();
            $sql->setTable(rex::getTable('erecht24'));
            
            // Check if domain exists
            $exists = $sql->setWhere(['domain' => $domain])->select()->getRows() > 0;
            
            $sql->setValue('domain', $domain);
            $sql->setValue('api_key', $apiKey);
            $sql->setValue('client_id', $registeredClient->getClientId());
            $sql->setValue('secret', $registeredClient->getSecret());
            $sql->setValue('updatedate', date('Y-m-d H:i:s'));
            
            if ($exists) {
                $sql->setWhere(['domain' => $domain]);
                $sql->update();
            } else {
                $sql->setValue('createdate', date('Y-m-d H:i:s'));
                $sql->insert();
            }

            return true;

        } catch (Throwable $e) {
            // Log error
            rex_logger::logError(1, $e->getMessage(), __FILE__, __LINE__);
            throw new rex_exception('Failed to register eRecht24 client: ' . $e->getMessage());
        }
    }

    public static function unregister(string $domain): bool 
    {
        try {
            // Get client info
            $sql = rex_sql::factory();
            $client = $sql->setTable(rex::getTable('erecht24'))
                         ->setWhere(['domain' => $domain])
                         ->select()
                         ->getArray();

            if (empty($client)) {
                return true; // Already gone
            }

            $client = $client[0];

            // Delete from eRecht24
            if ($client['api_key'] && $client['client_id']) {
                $apiHandler = new eRecht24\RechtstexteSDK\ApiHandler($client['api_key'], self::PLUGIN_KEY);
                $apiHandler->deleteClient((int)$client['client_id']);
            }

            // Delete from database
            rex_sql::factory()
                ->setTable(rex::getTable('erecht24'))
                ->setWhere(['domain' => $domain])
                ->delete();

            // Delete texts
            rex_sql::factory()
                ->setTable(rex::getTable('erecht24_texts'))
                ->setWhere(['domain' => $domain])
                ->delete();

            return true;

        } catch (Throwable $e) {
            rex_logger::logError(1, $e->getMessage(), __FILE__, __LINE__);
            throw new rex_exception('Failed to unregister eRecht24 client: ' . $e->getMessage());
        }
    }

    private static function buildPushUrl(): string
    {
        // Build the push URL that eRecht24 will call
        $url = rex::getServer();
        $url .= 'index.php?rex-api-call=erecht24_push';
        return $url;
    }
}
