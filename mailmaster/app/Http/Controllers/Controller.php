<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="MailMaster API",
 *     description="API de gestion de campagnes de newsletters",
 *     @OA\Contact(
 *         email="support@mailmaster.local"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Serveur local"
 * )
 *
 * @OA\Schema(
 *     schema="Newsletter",
 *     type="object",
 *     required={"title", "content"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the newsletter"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the newsletter"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="The content of the newsletter"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the newsletter was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the newsletter was last updated"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Subscriber",
 *     type="object",
 *     required={"email"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the subscriber"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="The email of the subscriber"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the subscriber"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the subscriber was added"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the subscriber was last updated"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Campaign",
 *     type="object",
 *     required={"newsletter_id", "scheduled_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the campaign"
 *     ),
 *     @OA\Property(
 *         property="newsletter_id",
 *         type="integer",
 *         description="The ID of the associated newsletter"
 *     ),
 *     @OA\Property(
 *         property="scheduled_at",
 *         type="string",
 *         format="date-time",
 *         description="The scheduled time for the campaign"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the campaign was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the campaign was last updated"
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
