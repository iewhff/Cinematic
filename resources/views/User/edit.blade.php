@extends('layout.base')

@section('main')

<tbody>
    <form novalidate class="needs-validation" method="POST" action="{{ route('user.update', ['user' => $user]) }}">
        @csrf
        @method('PUT')
        @include('User.shared.campos')
        <div class="my-4 d-flex justify-content-end" style="position: fixed; bottom: 0;">
            <button type="submit" style="margin-left:100px" class="btn btn-success btn-lg" name="ok">Guardar Alterações</button>
            <a href="{{ route('user.index')}}" class="btn btn-danger btn-lg">Cancelar</a>
        </div>
    </form>
</tbody>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection