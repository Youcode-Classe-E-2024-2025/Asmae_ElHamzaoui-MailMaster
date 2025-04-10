<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\NewsletterService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Newsletters",
 *     description="API Endpoints for newsletter management"
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
     *     summary="Get all newsletters",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all newsletters",
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
     *     summary="Create a new newsletter",
     *     security={{"bearerAuth":{}}},
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
     *         description="Newsletter successfully created",
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
     *     summary="Get a specific newsletter",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter details",
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
     *     summary="Update a newsletter",
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
     *             @OA\Property(property="title", type="string", example="Titre mis à jour"),
     *             @OA\Property(property="content", type="string", example="Contenu mis à jour de la newsletter.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter successfully updated",
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
     *     summary="Delete a newsletter",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter successfully deleted"
     *     )
     * )
     */
    public function destroy($id)
    {
        return response()->json($this->newsletterService->delete($id));
    }
}
