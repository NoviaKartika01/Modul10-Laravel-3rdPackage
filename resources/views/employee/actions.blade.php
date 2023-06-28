<div class="d-flex">
    {{-- button untuk melihat datail karyawan --}}
    <a href="{{ route('employees.show', ['employee' => $employee->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i class="bi-person-lines-fill"></i></a>
    {{-- button untuk mengedit data karyawan berdasarkan id karyawan --}}
    <a href="{{ route('employees.edit', ['employee' => $employee->id]) }}" class="btn btn-outline-dark btn-sm me-2"><i class="bi-pencil-square"></i></a>

    <div>
        {{-- button untuk menghapus fata karyawan berdasarkan id karyawan --}}
        <form action="{{ route('employees.destroy', ['employee' => $employee->id]) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-dark btn-sm me-2"><i class="bi-trash"></i></button>
        </form>
    </div>
</div>

