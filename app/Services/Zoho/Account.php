<?php
declare(strict_types=1);
namespace App\Services\Zoho;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\record\BodyWrapper;

class Account extends Service
{
    public function create($data)
    {
        $recordOperations = new RecordOperations();
        $account = new Record();
        $account->addKeyValue('Account_Name', $data['account_name']);
        $account->addKeyValue('Phone', $data['phone']);
        $account->addKeyValue('Website', $data['website']);
        $bodyWrapper = new BodyWrapper();
        $bodyWrapper->setData([$account]);
         try {
             $response = $recordOperations->createRecords('Accounts', $bodyWrapper);
             $statusCode = $response->getStatusCode();
             if ($statusCode == 201) {
                  $data = $response->getObject()->getData();
                  return $data[0]->getStatus()->getValue();
            }
         } catch (\Exception $e) {}

        return 'error';
    }
}
