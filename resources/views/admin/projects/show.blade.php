@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>ID: {{ $project->id }}</span>
                    <div class="status">
                        @if ($project->status === 1)
                            <span class="badge rounded-pill bg-success text-light">Completed</span>
                        @elseif ($project->status === 0)
                            <span class="badge rounded-pill bg-warning text-dark">Suspended</span>
                        @else
                            <span class="badge rounded-pill bg-danger text-light">Planning</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="text-center">
                        Title: <strong>{{ $project->title }}</strong>
                    </h4>

                    <figure class="figure w-100">
                        @if (str_starts_with($project->image, 'http'))
                            <img src="{{ $project->image }}" class="figure-img img-fluid rounded" alt="{{ $project->title }}">
                        @else
                            <img src="{{ asset('storage/' . $project->image) }}" class="figure-img img-fluid rounded" alt="{{ $project->title }}">
                        @endif
                        <figcaption class="figure-caption text-center">Preview for the above image.</figcaption>
                    </figure>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Description Project
                            </button>
                          </h2>
                          <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>
                                    {{ $project->description }}
                                </p>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Goals
                            </button>
                          </h2>
                          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    @foreach (json_decode($project->goals) as $goal)
                                        <li>{{ $goal }}</li>
                                    @endforeach
                                </ul>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Miscellaneous
                            </button>
                          </h2>
                          <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>
                                    Partecipants: {{ $project->nPartecipants }}
                                </p>
                                <p>
                                    Budget: {{ $project->budget }}$
                                </p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning">
                        Edit
                    </a>
                    <form class="d-inline-block" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
