<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\NewsletterService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Newsletters",
 *     description="Gestion des newsletters"
 * )
 */
class NewsletterController extends Controller
{
    protected $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    /**
     * @OA\Get(
     *     path="/newsletters",
     *     tags={"Newsletters"},
     *     summary="Liste des newsletters",
     *     description="Récupère toutes les newsletters existantes",
     *     @OA\Response(
     *         response=200,
     *         description="Liste récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Newsletter")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->newsletterService->getAll());
    }

    /**
     * @OA\Post(
     *     path="/newsletters",
     *     tags={"Newsletters"},
     *     summary="Créer une nouvelle newsletter",
     *     description="Crée une nouvelle newsletter avec un titre et un contenu",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string", example="Nouvelle Newsletter"),
     *             @OA\Property(property="content", type="string", example="Contenu de la newsletter.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Newsletter créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Newsletter")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        return response()->json($this->newsletterService->create($data), 201);
    }

    /**
     * @OA\Get(
     *     path="/newsletters/{id}",
     *     tags={"Newsletters"},
     *     summary="Voir une newsletter",
     *     description="Récupère les détails d'une newsletter spécifique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la newsletter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de la newsletter récupérés avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Newsletter")
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json($this->newsletterService->getById($id));
    }

    /**
     * @OA\Put(
     *     path="/newsletters/{id}",
     *     tags={"Newsletters"},
     *     summary="Mettre à jour une newsletter",
     *     description="Met à jour les informations d'une newsletter existante",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la newsletter à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Nouvelle version de la newsletter"),
     *             @OA\Property(property="content", type="string", example="Nouveau contenu mis à jour.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Newsletter")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        return response()->json($this->newsletterService->update($id, $data));
    }

    /**
     * @OA\Delete(
     *     path="/newsletters/{id}",
     *     tags={"Newsletters"},
     *     summary="Supprimer une newsletter",
     *     description="Supprime une newsletter en utilisant son ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la newsletter à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter supprimée avec succès"
     *     )
     * )
     */
    public function destroy($id)
    {
        return response()->json($this->newsletterService->delete($id));
    }
}
