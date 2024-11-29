<?php

namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
class PostService
{
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
