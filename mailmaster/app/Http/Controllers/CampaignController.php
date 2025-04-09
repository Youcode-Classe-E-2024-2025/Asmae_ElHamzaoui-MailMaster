<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Campaigns",
 *     description="Gestion des campagnes"
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
     *     summary="Liste des campagnes",
     *     description="Récupère toutes les campagnes existantes",
     *     @OA\Response(
     *         response=200,
     *         description="Liste récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Campaign")
     *         )
     *     )
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
     *     summary="Créer une nouvelle campagne",
     *     description="Crée une nouvelle campagne en associant une newsletter et une date d'envoi programmée",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"newsletter_id", "scheduled_at"},
     *             @OA\Property(property="newsletter_id", type="integer", example=1),
     *             @OA\Property(property="scheduled_at", type="string", format="date-time", example="2025-04-10T12:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campagne créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     )
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
     *     summary="Voir une campagne",
     *     description="Récupère les détails d'une campagne spécifique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la campagne",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de la campagne récupérés avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     )
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
     *     summary="Mettre à jour une campagne",
     *     description="Met à jour les informations d'une campagne existante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la campagne à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="newsletter_id", type="integer", example=1),
     *             @OA\Property(property="scheduled_at", type="string", format="date-time", example="2025-04-15T12:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campagne mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     )
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
     *     summary="Supprimer une campagne",
     *     description="Supprime une campagne en utilisant son ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la campagne à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campagne supprimée avec succès"
     *     )
     * )
     */
    public function destroy($id)
    {
        return response()->json($this->campaignService->delete($id));
    }
}
