<?php

namespace App\Repositories\Eloquent;

use App\Models\FormVersion;
use App\Repositories\Contracts\FormVersionRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class FormVersionRepository extends BaseRepository implements FormVersionRepositoryInterface
{
    public function model(): string
    {
        return FormVersion::class;
    }

    public function getActiveVersion(int $formId)
    {
        return $this->model
            ->where('form_id', $formId)
            ->where('status', 'active')
            ->with('fields')
            ->first();
    }

    public function createVersion(int $formId, array $data): FormVersion
    {
        $lastVersion = $this->model
            ->where('form_id', $formId)
            ->max('version') ?? 0;

        return $this->model->create([
            'form_id' => $formId,
            'version' => $lastVersion + 1,
            'status'  => 'draft',
            ...$data,
        ]);
    }

    public function activateVersion(int $formId, string $status): void
    {
        if ($status !== 'active') return;

        // Archive version in active
        $this->model
            ->where('form_id', $formId)
            ->where('status', 'active')
            ->update(['status' => 'archived']);

        // Activate new version
        $this->model
            ->where('form_id', $formId)
            ->where('status', 'draft')
            ->latest()
            ->firstOrFail()
            ->update([
                'status'       => 'active',
                'published_at' => now(),
            ]);
    }
}
