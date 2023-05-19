<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Laravel</title>
</head>

<body>

    <h5>
        <center>Lesson Plan</center>
    </h5>
    <span style="font-size: x-small;"><strong>School Name:</strong> Gashora Girls Academy</span>
    <span style="float: right; font-size: x-small;"><strong>Teacher's Name:</strong> {{ $lessons->f_name}}
        {{ $lessons->l_name}}</span>

    <table class="table table-sm table-bordered mt-2" style="font-size: x-small;">
        <tr>
            <td width="20%">Term</td>
            <td width="12%">Date: <br />{{$lessons->date}}</td>
            <td width="20%">Subject: <br />{{$lessons->subjectName}}</td>
            <td width="15%">Class: <br />{{$lessons->className}}</td>
            <td colspan="2">Unit: <br />{{$lessons->unit_no}}</td>
            <td>Duration: <br />{{$lessons->duration}}</td>
            <td>Size: <br />{{$lessons->size}}</td>
        </tr>
        <tr>
            <td>Title of Unit </td>
            <td colspan="7">{{$lessons->unitName}}</td>
        </tr>
        <tr>
            <td>Topic Area </td>
            <td colspan="7">{{$lessons->topic_area}}</td>
        </tr>
        <tr>
            <td>Key Unit Competence </td>
            <td colspan="7">{!! $lessons->key_unit_competence !!}</td>
        </tr>
        <tr>
            <td>Title of the lesson </td>
            <td colspan="7">{{$lessons->lessonTitle}}</td>
        </tr>
        <tr>
            <td>Instructional Objective </td>
            <td colspan="7">{!! $lessons->instructional_objective !!}</td>
        </tr>
        <tr>
            <td rowspan="2">Class Setting </td>
            <td colspan="4" rowspan="2">
                <strong>Location: </strong>{{$lessons->location}}<strong></strong>
            </td>
            <td colspan="3"><strong>Learners with SEN&nbsp;</strong></td>
        </tr>
        <tr>
            <td colspan="3">Visual impairment (low): {{$lessons->learner_with_SEN}}</td>
        </tr>
        <tr>
            <td>Learning Objectives <br />(inclusive to reflect needs of whole class): </td>
            <td colspan="7">
                <p><strong>Knowledge &amp; Understanding: </strong><br />{!!$lessons->knowledge_and_understanding !!}
                </p>
                <p><strong>Skills:</strong>{!!$lessons->skills !!}</p>
                <p><strong>Attitudes &amp;Values: </strong>{!!$lessons->attitudes_and_values !!}</p>
            </td>
        </tr>
        <tr>
            <td>Materials</td>
            <td colspan="7">{!! $lessons->teaching_materials !!}</td>
        </tr>
        <tr>
            <td rowspan="3"><strong>Steps/timing </strong></td>
            <td colspan="5"><strong>Description of teaching and learning activity</strong></td>
            <td colspan="2" rowspan="3"><strong>Competences (skills and attitudes, cross cutting issues to be addressed)
                    to develop</strong></td>
        </tr>
        <tr>
            <td colspan="5">{!! $lessons-> description_of_teaching !!}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Teachers activities</strong></td>
            <td colspan="3"><strong>Learners activities</strong></td>
        </tr>
        @foreach($lessonParts as $item )
        <tr>
            <td>{{$item->type}} <br />{{$item->duration}}'</td>
            <td colspan="2">{!!$item->teacher_activities!!}</td>
            <td colspan="3">{!! $item->learner_activities !!}</td>
            <td colspan="2">{!! $item->competences !!}</td>
        </tr>
        @endforeach

        </tr>
        <tr>
            <td>Lesson evaluation </td>
            <td colspan="7">

            </td>
        </tr>
        <tr>
            <td>References</td>
            <td colspan="7">{!! $lessons->reference !!}</td>
        </tr>
    </table>
</body>

</html>