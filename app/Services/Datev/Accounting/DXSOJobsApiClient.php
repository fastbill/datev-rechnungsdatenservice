<?php

namespace App\Services\Datev\Accounting;

use App\Enums\Datev\Accounting\DXSOJobImportType;
use App\Exceptions\Datev\Accounting\DXSOJobs\MissingDXSOJobParameter;
use App\Services\Datev\Accounting\DXSOJobs\DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DXSOJobsApiClient
{
    /**
     * Returns a list of all clients to which the user has access.
     */
    public function getClients(): mixed
    {
        $response = Http::accountingDXSOJobs()->get('/clients');

        return $response->json();
    }

    /**
     * Returns a list of basic data about a given client.
     */
    public function getClientData(string $client_id): mixed
    {
        $response = Http::accountingDXSOJobs()->get("/clients/$client_id");

        return $response->json();
    }

    /**
     * Create a data transfer (dxso-job) and return its ID
     *
     * @throws MissingDXSOJobParameter
     */
    public function createDataTransfer(string $client_id, ?DXSOJobImportType $import_type, ?DateTime $accounting_month): mixed
    {
        $request_data = null;

        if (isset($import_type)) {
            $request_data = ['json' => ['import_type' => $import_type->value]];
        }

        if (isset($accounting_month)) {
            $request_data['json']['accounting_month'] = $accounting_month->format('o-m');
        }

        if (isset($import_type) && ! isset($accounting_month)) {
            throw new MissingDXSOJobParameter('The parameter accounting_month is required if the parameter import_type is set!');
        }

        $response = Http::accountingDXSOJobs()
            ->post("/clients/$client_id/dxso-jobs", $request_data);

        return $response->json();
    }

    /**
     * Attaches files to a data transfer (dxso-job).
     */
    public function attachFileToDataTransfer(string $client_id, string $job_id): mixed
    {
        $response = Http::accountingDXSOJobs()
            ->post("/clients/$client_id/dxso-jobs/$job_id/files");

        return $response->json();
    }

    /**
     * Get the status of a data transfer (dxso-job).
     */
    public function getStatusOfDataTransfer(string $client_id, string $job_id): mixed
    {
        $response = Http::accountingDXSOJobs()
            ->get("/clients/$client_id/dxso-jobs/$job_id");

        return $response->json();
    }

    /**
     * Finalizes the data transfer (dxso-job).
     */
    public function finalizeDataTransfer(string $client_id, string $job_id): mixed
    {
        $response = Http::accountingDXSOJobs()
            ->put("/clients/$client_id/dxso-jobs/$job_id");

        return $response->json();
    }

    /**
     * Cancels a data transfer (dxso-job) that has not been finalized yet.
     */
    public function cancelUnfinalizedDataTransfer(string $client_id, string $job_id): mixed
    {
        $response = Http::accountingDXSOJobs()
            ->delete("/clients/$client_id/dxso-jobs/$job_id");

        return $response->json();
    }

    /**
     * Get protocol entries of a data transfer (dxso-job).
     */
    public function getProtocolEntriesOfDataTransfer(string $client_id, string $job_id): Collection
    {
        $response = Http::accountingDXSOJobs()
            ->get("/clients/$client_id/dxso-jobs/$job_id/protocol-entries");

        return $response->collect();
    }
}
