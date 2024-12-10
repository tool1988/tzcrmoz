<?php
declare(strict_types=1);
namespace App\Services\Zoho;

use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\record\BodyWrapper;
class Deal
{
    public function create($data)
    {
        $recordOperations = new RecordOperations();
        $deal = new Record();
        $deal->addKeyValue('Deal_Name', $data['deal_name']);
        $deal->addKeyValue('Stage', $data['deal_stage']);
        $deal->addKeyValue('Account_Name', $data['account_name']);
        $bodyWrapper = new BodyWrapper();
        $bodyWrapper->setData([$deal]);
        try {
            $response = $recordOperations->createRecords('Deals', $bodyWrapper);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 201) {
                $data = $response->getObject()->getData();
                return $data[0]->getStatus()->getValue();
            }
        } catch (\Exception $e) {}

        return 'error';

    }
}
