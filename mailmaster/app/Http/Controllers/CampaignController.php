<?php

namespace App\Http\Controllers;

use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Campaigns",
 *     description="API Endpoints for campaign management"
 * )
 */
class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     * @OA\Get(
     *     path="/campaigns",
     *     tags={"Campaigns"},
     *     summary="Get all campaigns",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of all campaigns")
     * )
     */
    public function index()
    {
        return response()->json($this->campaignService->getAll());
    }

    /**
     * @OA\Post(
     *     path="/campaigns",
     *     tags={"Campaigns"},
     *     summary="Create a new campaign",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"newsletter_id", "scheduled_at"},
     *             @OA\Property(property="newsletter_id", type="integer", example=1),
     *             @OA\Property(property="scheduled_at", type="string", format="date-time", example="2025-04-10T12:00:00")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Campaign successfully created")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'newsletter_id' => 'required|exists:newsletters,id',
            'scheduled_at' => 'required|date',
        ]);

        return response()->json($this->campaignService->create($data), 201);
    }

    /**
     * @OA\Get(
     *     path="/campaigns/{id}",
     *     tags={"Campaigns"},
     *     summary="Get a specific campaign",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Campaign details")
     * )
     */
    public function show($id)
    {
        return response()->json($this->campaignService->getById($id));
    }

    /**
     * @OA\Put(
     *     path="/campaigns/{id}",
     *     tags={"Campaigns"},
     *     summary="Update a specific campaign",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="newsletter_id", type="integer", example=2),
     *             @OA\Property(property="scheduled_at", type="string", format="date-time", example="2025-04-15T09:30:00")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Campaign successfully updated")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'newsletter_id' => 'sometimes|exists:newsletters,id',
            'scheduled_at' => 'sometimes|date',
        ]);

        return response()->json($this->campaignService->update($id, $data));
    }

    /**
     * @OA\Delete(
     *     path="/campaigns/{id}",
     *     tags={"Campaigns"},
     *     summary="Delete a specific campaign",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Campaign successfully deleted")
     * )
     */
    public function destroy($id)
    {
        return response()->json($this->campaignService->delete($id));
    }
}
