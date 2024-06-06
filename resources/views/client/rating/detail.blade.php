<div class="modal fade" id="points-detail-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Модальное окно</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                @php
                    $totalPoints = 0;
                    $totalKeys = 0;
                @endphp
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" colspan="3" class="text-center">Список заданий</th>
                    </tr>
                    <tr>
                        <th scope="col" style="width: 50%">Задание</th>
                        <th scope="col" style="width: 25%">Баллы</th>
                        <th scope="col" style="width: 25%">Эврики</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignedTasks as $assignedTask)
                        @php
                            $totalPoints += $assignedTask['points'] ?? 0;
                            $totalKeys += $assignedTask['key_count'] ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $assignedTask['name'] }}</td>
                            <td>{{ $assignedTask['points'] ?? 0 }}</td>
                            <td>{{ $assignedTask['key_count'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Итого:</th>
                        <th>{{ $totalPoints }}</th>
                        <th>{{ $totalKeys }}</th>
                    </tr>
                    </tfoot>
                </table>

                @if($participants)
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Команда</th>
                        </tr>
                        <tr>
                            <th scope="col" style="width: 60%">Имя</th>
{{--                            <th scope="col" style="width: 40%">Процент вовлеченности</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($participants as $participant => $efficiencyPercentage)
                            <tr>
                                <td>{{ $participant }}</td>
{{--                                <td>{{ $efficiencyPercentage }} %</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h5 class="text-center">Команда не определена</h5>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
