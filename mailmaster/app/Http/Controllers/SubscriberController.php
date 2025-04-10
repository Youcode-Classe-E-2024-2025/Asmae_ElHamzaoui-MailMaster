<?php

namespace App\Http\Controllers;

use App\Services\SubscriberService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Subscribers",
 *     description="API Endpoints for subscriber management"
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
     *     summary="Get all subscribers",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of all subscribers")
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
     *     summary="Create a new subscriber",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="subscriber@example.com"),
     *             @OA\Property(property="name", type="string", example="John Doe")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Subscriber successfully created")
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
     *     path="/subscribers/{subscriber}",
     *     tags={"Subscribers"},
     *     summary="Get a specific subscriber",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="subscriber",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Subscriber details")
     * )
     */
    public function show($id)
    {
        return response()->json($this->subscriberService->getById($id));
    }

    /**
     * @OA\Put(
     *     path="/subscribers/{subscriber}",
     *     tags={"Subscribers"},
     *     summary="Update a specific subscriber",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="subscriber",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="newsubscriber@example.com"),
     *             @OA\Property(property="name", type="string", example="Jane Doe")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Subscriber successfully updated")
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
     *     path="/subscribers/{subscriber}",
     *     tags={"Subscribers"},
     *     summary="Delete a specific subscriber",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="subscriber",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Subscriber successfully deleted")
     * )
     */
    public function destroy($id)
    {
        return response()->json($this->subscriberService->delete($id));
    }
}
