<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel CRUD</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Form Styles */
        form {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
        }

        form label {
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        form button[type="submit"],
        form button[type="button"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .card-header {
    margin-bottom: 15px;
}

        /* Subject and Teacher Styles */
        .subject-teacher-weight-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .subject-teacher-weight-row input[type="text"] {
            flex-grow: 1;
        }

        .subject-teacher-weight-row button {
            flex-shrink: 0;
        }

        /* Alerts */
        .alert {
            margin-top: 20px;
        }

        /* Buttons */
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            margin-top: 20px;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            
        }
        /* Add this to your existing styles */
.form-control.is-invalid {
    border-color: red;
}
.error-message {
    color: red;
    font-size: 12px;
    margin-top: 5px;
}
.invalid-feedback {
    color: red;
    font-size: 12px;
    margin-top: 5px;
}


    
    </style>
</head>

<body>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Student') }}</div>

                    <div class="card-body">
                        <input type="hidden" name="subject_teacher_weight_index" id="subject_teacher_weight_index" value="0">
                        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="standard">{{ __('Standard') }}</label>
                                <input id="standard" type="text"
                                    class="form-control" name="standard"
                                    value="{{ old('standard') }}" autocomplete="standard" autofocus>
                                    @error('standard')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                             
                            </div>

                            <div class="form-group">
                                <label for="capacity">{{ __('Capacity') }}</label>
                                <input id="capacity" type="text"
                                    class="form-control" name="capacity"
                                    value="{{ old('capacity') }}" autocomplete="capacity">
                                    @error('capacity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                             
                            </div>

                            <div class="form-group">
                                <label for="file">{{ __('Upload certificate') }}</label>
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>

                            <div class="form-group">
                                <label>{{ __('Subjects and Teachers') }}</label>
                                <div class="subject-teachers-weight-container">
                                    @foreach (old('subject_teacher_weight', [['subject' => '', 'teacher' => '', 'weight' => '']]) as $index => $subjectTeacher)
                                    <div class="subject-teacher-weight-row">

                                        <input type="text" class="form-control" name="subject_teacher_weight[0][subject]"
                                            placeholder="Enter subject name" value="{{ old('subject_teacher_weight.0.subject') }}">
                                            @error('subject_teacher_weight.' . $index . '.subject')
                <div class="error-message">
                    <small class="text-danger">{{ $message }}</small>
                </div>
                @enderror
                                        <input type="text" class="form-control" name="subject_teacher_weight[0][teacher]"
                                            placeholder="Enter teacher name" value="{{ old('subject_teacher_weight.0.teacher') }}">
                                            @error('subject_teacher_weight.' . $index . '.teacher')
                <div class="error-message">
                    <small class="text-danger">{{ $message }}</small>
                </div>
                @enderror
                                            <input type="text" class="form-control" name="subject_teacher_weight[0][weight]"
                                            placeholder="Enter weight" value="{{ old('subject_teacher_weight.0.weight') }}">
                                            @error('subject_teacher_weight.' . $index . '.weight')
                                            <div class="error-message">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                            @enderror
                                        <button type="button"
                                            class="btn btn-danger remove-subject-teacher-weight">Remove</button>
                                    </div>
                                       @endforeach
                                </div>
                                <button type="button" class="btn btn-primary add-subject-teacher-weight">Add Subject and
                                    Teacher</button>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create Student') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 



    <script>
        $(document).ready(function() {
            var subjectTeacherWeightIndex = 1;

            $('.add-subject-teacher-weight').on('click', function() {
                var newSubjectTeacherWeightRow = `
                <div class="subject-teacher-weight-row">
        <input type="text" class="form-control subject-teacher-weight" name="subject_teacher_weight[${subjectTeacherWeightIndex}][subject]" placeholder="Enter Subject">
        <input type="text" class="form-control subject-teacher-weight" name="subject_teacher_weight[${subjectTeacherWeightIndex}][teacher]" placeholder="Enter teacher name">
        <input type="text" class="form-control subject-teacher-weight" name="subject_teacher_weight[${subjectTeacherWeightIndex}][weight]" placeholder="Enter weight">
        <button type="button" class="btn btn-danger remove-subject-teacher-weight">Remove</button>
    </div>`;
                $('.subject-teachers-weight-container').append(newSubjectTeacherWeightRow);
                updateRemoveButtons();
                subjectTeacherWeightIndex++;
            });

            $(document).on('click', '.remove-subject-teacher-weight', function() {
                if ($('.subject-teacher-weight-row').length > 1) {
                    $(this).closest('.subject-teacher-weight-row').remove();
                    updateRemoveButtons();
                }
            });

            function updateRemoveButtons() {
                $('.subject-teacher-weight-row').each(function(index) {
                    if (index === 0) {
                        $(this).find('.remove-subject-teacher-weight').hide();
                    } else {
                        $(this).find('.remove-subject-teacher-weight').show();
                    }
                });
            }

            updateRemoveButtons();
        });
    </script>
</body>

</html>
