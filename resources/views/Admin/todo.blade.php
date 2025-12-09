<!-- ====================================== -->
<!--           TODO LIST GRADIENT          -->
<!-- ====================================== -->

<div class="p-4 text-white mt-4"
     style="
        border-radius:18px;
        background: linear-gradient(135deg, #1e3c72, #5f4b8b, #ff7eb9);
        box-shadow:0 4px 14px rgba(0,0,0,0.15);
     ">

    <h5 class="fw-bold mb-3">
        <i class="bi bi-check2-square me-1"></i> Todo List
    </h5>

    <!-- Form Tambah Todo -->
    <form action="{{ route('todo.store') }}" method="POST" class="mb-3">
        @csrf

        <div class="row g-3">

            <div class="col-md-6">
                <input type="text" name="title" class="form-control"
                       placeholder="Tambah todo baru..."
                       style="border-radius:10px; padding:10px;">
            </div>

            <div class="col-md-3">
                <input type="date" name="due_date" class="form-control"
                       style="border-radius:10px; padding:10px;">
            </div>

            <div class="col-md-3">
                <button class="btn w-100"
                        style="
                            background:rgba(255,255,255,0.25);
                            border-radius:10px;
                            color:white;
                            font-weight:600;
                            padding:10px;
                        ">
                    Tambah
                </button>
            </div>

        </div>
    </form>

    <hr style="border-color:rgba(255,255,255,0.25);">

    <!-- Daftar Todo -->
    @if($todos->isEmpty())
        <p class="mt-3 text-white-50">Belum ada todo</p>
    @else

        <ul class="mt-3" style="list-style:none; padding-left:0;">

            @foreach($todos as $todo)

                <li class="d-flex justify-content-between align-items-center mb-2"
                    style="
                        background:rgba(255,255,255,0.18);
                        border-radius:12px;
                        padding:12px 15px;
                        transition:0.2s;
                    "
                    onmouseover="this.style.background='rgba(255,255,255,0.28)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.18)'"
                >

                    <div class="d-flex align-items-center">

                        <input type="checkbox"
                               onclick="location.href='{{ route('todo.toggle', $todo->id) }}'"
                               {{ $todo->is_done ? 'checked' : '' }}
                               class="form-check-input me-2"
                               style="transform:scale(1.2);">

                        <div>
                            <span style="
                                text-decoration: {{ $todo->is_done ? 'line-through' : 'none' }};
                                font-weight:500;
                                font-size:15px;
                            ">
                                {{ $todo->title }}
                            </span>

                            @if($todo->due_date)
                                <small class="ms-2 text-white-50">
                                    ({{ $todo->due_date }})
                                </small>
                            @endif
                        </div>

                    </div>

                    <a href="{{ route('todo.delete', $todo->id) }}"
                       onclick="return confirm('Hapus todo ini?')"
                       class="text-white-50"
                       style="font-size:15px;">
                        <i class="bi bi-trash"></i>
                    </a>

                </li>

            @endforeach

        </ul>

    @endif

</div>
