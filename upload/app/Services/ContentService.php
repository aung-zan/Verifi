<?php

namespace App\Services;

use App\Models\Content;
use App\Repositories\ContentRepository;
use Illuminate\Database\Eloquent\Collection;

class ContentService
{
    private $db;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->db = $contentRepository;
    }

    /**
     * Return the content collection.
     */
    public function getContentList(array $data): Collection
    {
        $filter = [];
        $search = [];

        $filter['user_id'] = (int) $data['user_id'];

        // filter with only status. can move to trait.
        foreach ($data['filter'] as $column => $value) {
            $filter[$column] = (int) $value;
        }

        return $this->db->get($filter, $search);
    }

    /**
     * Create the content.
     */
    public function createContent(array $data): Content
    {
        $content = $this->db->create($data);

        $message = json_encode([
            'id' => $content->id,
            'user_id' => $content->user_id,
            'content' => $content->content,
        ]);

        if (env('APP_ENV') !== 'testing') {
            $rabbitmq = new RabbitMQService();
            $rabbitmq->sendWithDirectExchange(env('RABBITMQ_EXCHANGE'), 'content', $message);
            $rabbitmq->close();
        }

        return $content;
    }

    /**
     * Return the specific content by id or 404.
     */
    public function getContent(int $id): ?Content
    {
        return $this->db->getById($id);
    }

    /**
     * Return the specific content by id and user id or 404.
     */
    public function getContentWithUserId(int $id, int $userId): ?Content
    {
        // $content = $this->db->getWithUserId($id, $userId);
        // $result = $content->result;
        // $citations = json_decode($result->citations)?->links;
        // \Log::info($citations);

        // return $content;

        return $this->db->getWithUserId($id, $userId);
    }

    /**
     * Update the specific content.
     */
    public function updateContent(int $id, array $data): ?Content
    {
        return $this->db->update($id, $data);
    }

    /**
     * Delete the specific content.
     */
    public function deleteContent(int $id): void
    {
        $this->db->delete($id);
    }
}
