<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="MailMaster API",
 *     version="1.0.0",
 *     description="API de gestion de campagnes de newsletters",
 *     @OA\Contact(
 *         email="support@mailmaster.local",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Server(
 *     url="/api",
 *     description="MailMaster API Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for user authentication"
 * )
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints for managing users"
 * )
 * @OA\Tag(
 *     name="Subscribers",
 *     description="API Endpoints for managing subscribers"
 * )
 * @OA\Tag(
 *     name="Newsletters",
 *     description="API Endpoints for managing newsletters"
 * )
 * @OA\Tag(
 *     name="Campaigns",
 *     description="API Endpoints for managing campaigns"
 * )
 * @OA\Components(
 *     @OA\Schema(
 *         schema="User",
 *         type="object",
 *         required={"name", "email", "role"},
 *         @OA\Property(property="id", type="integer", description="User ID"),
 *         @OA\Property(property="name", type="string", description="User name"),
 *         @OA\Property(property="email", type="string", description="User email"),
 *         @OA\Property(property="role", type="string", description="User role (admin, client, agent)"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation date")
 *     ),
 *     @OA\Schema(
 *         schema="Subscriber",
 *         type="object",
 *         required={"email", "name"},
 *         @OA\Property(property="id", type="integer", description="Subscriber ID"),
 *         @OA\Property(property="email", type="string", description="Subscriber email"),
 *         @OA\Property(property="name", type="string", description="Subscriber name"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation date")
 *     ),
 *     @OA\Schema(
 *         schema="Newsletter",
 *         type="object",
 *         required={"title", "content"},
 *         @OA\Property(property="id", type="integer", description="Newsletter ID"),
 *         @OA\Property(property="title", type="string", description="Newsletter title"),
 *         @OA\Property(property="content", type="string", description="Newsletter content"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation date")
 *     ),
 *     @OA\Schema(
 *         schema="Campaign",
 *         type="object",
 *         required={"name", "start_date", "end_date"},
 *         @OA\Property(property="id", type="integer", description="Campaign ID"),
 *         @OA\Property(property="name", type="string", description="Campaign name"),
 *         @OA\Property(property="start_date", type="string", format="date-time", description="Campaign start date"),
 *         @OA\Property(property="end_date", type="string", format="date-time", description="Campaign end date"),
 *         @OA\Property(property="status", type="string", description="Campaign status (active, completed, etc.)"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation date")
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
