<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\ContentCreateRequest;
use App\Http\Requests\api\ContentDeleteRequest;
use App\Http\Requests\api\ContentListRequest;
use App\Http\Requests\api\ContentUpdateRequest;
use App\Http\Resources\ContentCollection;
use App\Http\Resources\ContentResource;
use App\Services\ContentService;

class ContentController extends Controller
{
    private $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ContentListRequest $request)
    {
        $data = [
            'user_id' => auth()->guard('api')->id(),
            'filter' => $request->validated(),
        ];

        $contentList = $this->contentService->getContentList($data);

        // List of content info.
        return response()->json([
            'success' => true,
            'data' => new ContentCollection($contentList),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function store(ContentCreateRequest $request)
    {
        $filteredData = $request->validated();
        $filteredData['user_id'] = auth()->guard('api')->id();

        $content = $this->contentService->createContent($filteredData);

        // Created successfully.
        return response()->json([
            'success' => true,
            'data' => new ContentResource($content),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $userId = auth()->guard('api')->id();
        $content = $this->contentService->getContentWithUserId($id, $userId);

        // Content Info
        return response()->json([
            'success' => true,
            'data' => new ContentResource($content),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContentUpdateRequest $request, int $id)
    {
        $filteredData = $request->validated();

        $content = $this->contentService->updateContent($id, $filteredData);

        // Updated successfully.
        return response()->json([
            'success' => true,
            'data' => new ContentResource($content),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ContentDeleteRequest $request, int $id)
    {
        $this->contentService->deleteContent($id);

        // Deleted successfully.
        return response()->json([
            'success' => true,
            'message' => 'The content was deleted.',
        ], 200);
    }
}
