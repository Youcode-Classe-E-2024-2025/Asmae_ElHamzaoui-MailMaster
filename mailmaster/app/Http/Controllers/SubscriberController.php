<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SubscriberService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Subscribers",
 *     description="Gestion des abonnés"
 * )
 */
class SubscriberController extends Controller
{
    protected $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    /**
     * @OA\Get(
     *     path="/subscribers",
     *     tags={"Subscribers"},
     *     summary="Liste des abonnés",
     *     description="Récupère tous les abonnés",
     *     @OA\Response(
     *         response=200,
     *         description="Liste récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Subscriber")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->subscriberService->getAll());
    }

    /**
     * @OA\Post(
     *     path="/subscribers",
     *     tags={"Subscribers"},
     *     summary="Créer un nouvel abonné",
     *     description="Crée un nouvel abonné avec un email et un nom",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="subscriber@example.com"),
     *             @OA\Property(property="name", type="string", example="John Doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Abonné créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        return response()->json($this->subscriberService->create($data), 201);
    }

    /**
     * @OA\Get(
     *     path="/subscribers/{id}",
     *     tags={"Subscribers"},
     *     summary="Voir un abonné",
     *     description="Récupère les détails d'un abonné spécifique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'abonné",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de l'abonné récupérés avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json($this->subscriberService->getById($id));
    }

    /**
     * @OA\Put(
     *     path="/subscribers/{id}",
     *     tags={"Subscribers"},
     *     summary="Mettre à jour un abonné",
     *     description="Met à jour les informations d'un abonné existant",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'abonné à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="newsubscriber@example.com"),
     *             @OA\Property(property="name", type="string", example="Jane Doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Abonné mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Subscriber")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'sometimes|email|unique:subscribers,email,' . $id,
            'name' => 'sometimes|string|max:255',
        ]);

        return response()->json($this->subscriberService->update($id, $data));
    }

    /**
     * @OA\Delete(
     *     path="/subscribers/{id}",
     *     tags={"Subscribers"},
     *     summary="Supprimer un abonné",
     *     description="Supprime un abonné en utilisant son ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'abonné à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Abonné supprimé avec succès"
     *     )
     * )
     */
    public function destroy($id)
    {
        return response()->json($this->subscriberService->delete($id));
    }
}
