<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\ContentCreateRequest;
use App\Http\Requests\api\ContentUpdateRequest;
use App\Http\Requests\api\ContentDeleteRequest;
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
     */
    public function index()
    {
        $data = [
            'user_id' => auth()->guard('api')->id(),
            'filter' => request()->query()
        ];

        $contentList = $this->contentService->getContentList($data);

        if (is_string($contentList)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid filter field: ' . $contentList
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => new ContentCollection($contentList)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentCreateRequest $request)
    {
        $filteredData = $request->validated();
        $filteredData['user_id'] = auth()->guard('api')->id();

        $content = $this->contentService->createContent($filteredData);

        return response()->json([
            'success' => true,
            'data' => $content
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $userId = auth()->guard('api')->id();
        $content = $this->contentService->getContentWithUserId($id, $userId);

        return response()->json([
            'success' => true,
            'data' => new ContentResource($content)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentUpdateRequest $request, int $id)
    {
        $filteredData = $request->validated();

        $content = $this->contentService->updateContent($id, $filteredData);

        return response()->json([
            'success' => true,
            'data' => $content
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentDeleteRequest $request, int $id)
    {
        $this->contentService->deleteContent($id);

        return response()->json([
            'success' => true,
            'message' => 'The content was deleted.'
        ]);
    }
}
