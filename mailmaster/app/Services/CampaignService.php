<?php
namespace App\Services;

use App\Repositories\CampaignRepository;

class CampaignService
{
    protected $campaignRepository;

    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    public function getAll()
    {
        return $this->campaignRepository->all();
    }

    public function getById($id)
    {
        return $this->campaignRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->campaignRepository->create($data);
    }

    public function update($id, array $data)
    {
        $campaign = $this->campaignRepository->find($id);
        return $this->campaignRepository->update($campaign, $data);
    }

    public function delete($id)
    {
        $campaign = $this->campaignRepository->find($id);
        return $this->campaignRepository->delete($campaign);
    }
}
