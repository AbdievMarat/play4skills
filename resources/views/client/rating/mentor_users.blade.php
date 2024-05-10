<ol class="list-group list-group-numbered mt-2">
    @foreach($users as $user)
        <li
            class="list-group-item d-flex justify-content-between align-items-start points-detail"
            style="cursor: pointer;"
            data-user_id="{{ $user['id'] }}"
        >
            <div class="ms-2 me-auto">
                <div class="fw-bold">{{ $user['name'] }}</div>
            </div>
            <span class="badge bg-info rounded-pill me-2"><i class="bi bi-lightbulb"></i> {{ $user['total_keys'] ?? 0 }}</span>
            <span class="badge bg-primary rounded-pill">{{ $user['total_points'] }}</span>
        </li>
    @endforeach
</ol>
