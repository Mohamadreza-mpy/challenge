<?php

namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Blog Post API",
 *     version="1.0.0",
 *     description="API for managing blog posts with authors and comments."
 * )
 */
class PostService
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get list of posts",
     *     description="Returns a paginated list of posts with authors and comments.",
     *     @OA\Parameter(
     *         name="author_id",
     *         in="query",
     *         required=false,
     *         description="Filter posts by author ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=false,
     *         description="Search posts by title substring",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Specify the page number",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Number of items per page",
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */


      public function index($request):JsonResponse
      {
          // Fetch posts with eager loading to prevent
          $query = Post::with(['author', 'comments']);

          // Apply filters
          if ($request->has('author_id')) {
              $query->where('author_id', $request->author_id);
          }

          if ($request->has('title')) {
              $query->where('title', 'like', '%' . $request->title . '%');
          }

          // Pagination
          $perPage = $request->get('per_page', 15);
          $posts = $query->paginate($perPage);

          // Transform response
          $data = $posts->map(function ($post) {
              return [
                  'title' => $post->title,
                  'author' => $post->author->name,
                  'comments' => $post->comments->map(function ($comment) {
                      return [
                          'name' => $comment->name,
                          'text' => $comment->text,
                      ];
                  }),
              ];
          });

          return response()->json([
              'data' => $data,
              'meta' => [
                  'current_page' => $posts->currentPage(),
                  'total' => $posts->total(),
                  'per_page' => $posts->perPage(),
                  'last_page' => $posts->lastPage(),
              ],
          ]);
      }

      public function store():JsonResponse
      {
         // Service method logic
      }

      public function show():JsonResponse
      {
         // Service method logic
      }

      public function update():JsonResponse
      {
         // Service method logic
      }

      public function destroy():JsonResponse
      {
         // Service method logic
      }

}
