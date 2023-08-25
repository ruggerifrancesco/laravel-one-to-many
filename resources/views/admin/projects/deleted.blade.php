@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-3">
                <table class="table table-light m-0">
                    <thead>
                        <tr class="table-info">
                          <th scope="col">ID</th>
                          <th scope="col">Title</th>
                          <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr class="table-secondary">
                                <th scope="row">
                                    {{ $project->id }}
                                </th>
                                <td>
                                    {{ $project->title }}
                                </td>
                                <td>
                                    <form class="d-inline-block me-2" action="{{ route('admin.projects.restore', $project->id) }}" method="POST">
                                        @csrf
                                        @method('POST')

                                        <button type="submit" class="btn btn-warning">
                                            Restore
                                        </button>
                                    </form>
                                    <form class="d-inline-block" action="{{ route('admin.projects.obliterate', $project->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Obliterate
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-5">
                <div>
                    {{ $projects->links() }}
                </div>
                <div>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-success">
                        Return to index
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
