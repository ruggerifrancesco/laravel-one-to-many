@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <form action="{{ route('admin.projects.update', ['project'=>$project->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0">
                            <span>ID: {{ $project->id }}</span>
                            <strong>Update {{ $project->title }} Project</strong>
                        </h6>
                        <div>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="status-container d-flex align-items-center">
                            <h6 class="me-4 my-0">
                                <strong>Status Project:</strong>
                            </h6>
                            <label class="form-check-label me-4">
                                <input type="radio" name="status" value="" {{ $project->status === null ? 'checked' : '' }} class="form-check-input">
                                Currently in Development
                            </label>
                            <label class="form-check-label me-4">
                                <input type="radio" name="status" value="0" {{ $project->status === 0 ? 'checked' : '' }} class="form-check-input">
                                Suspended
                            </label>
                            <label class="form-check-label me-4">
                                <input type="radio" name="status" value="1" {{ $project->status === 1 ? 'checked' : '' }} class="form-check-input">
                                Completed
                            </label>
                        </div>
                        <div class="type-container d-flex align-items-center">
                            <h6 class="me-2 my-0">
                                <strong>Type:</strong>
                            </h6>
                            {{ $project->type->name }}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating {{ $errors->has('title') ? 'is-invalid' : '' }}">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                        placeholder="Project Name" value="{{ old( 'title' , $project->title) }}">
                                    <label for="title">Project Name</label>
                                </div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating {{ $errors->has('nPartecipants') ? 'is-invalid' : '' }}">
                                    <input type="number" class="form-control @error('nPartecipants') is-invalid @enderror" id="nPartecipants" name="nPartecipants" min="1"
                                        placeholder="Partecipants" value="{{ old( 'nPartecipants' , $project->nPartecipants) }}">
                                    <label for="nPartecipants">Partecipants</label>
                                </div>
                                @error('nPartecipants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="form-floating {{ $errors->has('budget') ? 'is-invalid' : '' }}">
                                        <input type="text" class="form-control @error('budget') is-invalid @enderror" id="budget" name="budget"
                                            placeholder="Budget" aria-label="Dollar amount (with dot and two decimal places)" value="{{ old( 'budget' , $project->budget) }}">
                                        <label for="budget">Budget</label>
                                    </div>
                                    <span class="input-group-text">$</span>
                                    <span class="input-group-text">0.00</span>
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="form-floating {{ $errors->has('description') ? 'is-invalid' : '' }}">
                                    <textarea class="form-control @error('description') is-invalid @enderror"" aria-label="Description" name="description"
                                        placeholder="Description">{{ old( 'description' , $project->description) }}</textarea>
                                    <label for="description">Description</label>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <div class="form-floating {{ $errors->has('goals') ? 'is-invalid' : '' }}">
                                                <input type="text" class="form-control @error('goals') is-invalid @enderror" id="newGoal"
                                                    placeholder="Goals">
                                                <label for="newGoal">Goals</label>
                                            </div>
                                            <button class="btn btn-outline-secondary" type="button" id="addGoalButton">Add Goal</button>
                                            @error('goals')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="imageUploader" name="image"
                                                aria-describedby="inputImage" aria-label="Upload" value="{{ $project->image }}">
                                            <div class="col-12 d-flex flex-column">
                                                @if (str_starts_with($project->image, 'http'))
                                                    <figcaption class="figure-caption text-end">
                                                        Current Image URL:
                                                        <span><a href="{{ $project->image }}" target="_blank">{{ $project->image }}</a></span>
                                                    </figcaption>
                                                @else
                                                    <figcaption class="figure-caption text-end">
                                                        Current Image:
                                                        <span>{{ $project->image }}</span>
                                                    </figcaption>
                                                @endif
                                            </div>

                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <ul class="list-group" id="goalPreviewList">
                                            @foreach (json_decode($project->goals) as $goal)
                                                <li class="list-group-item d-flex justify-content-between goal-item">
                                                    <span class="current-goal">{{ $goal }}</span>
                                                    <div class="goal-item-icon">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </div>
                                                    <input type="hidden" name="goals[]" value="{{ $goal }}">
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <figure class="figure img-preview-container edit">
                                            @if (str_starts_with($project->image, 'http'))
                                                <img src="{{ $project->image }}" class="figure-img img-fluid rounded" alt="{{ $project->title }}">
                                            @else
                                                <img src="{{ asset('storage/' . $project->image) }}" class="figure-img img-fluid rounded" alt="{{ $project->title }}">
                                            @endif
                                            <figcaption class="figure-caption text-end">A preview for the selected image.</figcaption>
                                        </figure>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
