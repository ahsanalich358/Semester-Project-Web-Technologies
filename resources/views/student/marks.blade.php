@extends('layouts.app')
@section('title', 'Mere Marks')
@section('page-title', 'Mere Marks')

@section('content')

<div class="card-box">
    <h5><i class="fas fa-star"></i> Assignment Marks</h5>

    @if($submissions->isEmpty())
        <div style="text-align:center; padding:40px; color:#9ca3af;">
            <i class="fas fa-star" style="font-size:3rem; opacity:.2;"></i>
            <p style="margin-top:14px;">Abhi koi submission nahi ki.<br>Pehle kisi course mein enroll ho aur assignment submit karo.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Course</th>
                        <th>Assignment</th>
                        <th>Submit Date</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $i => $sub)
                    @php
                        $marks = $sub->marks;
                        $grade = '—';
                        if ($marks !== null) {
                            if ($marks >= 80)      $grade = 'A';
                            elseif ($marks >= 70)  $grade = 'B';
                            elseif ($marks >= 60)  $grade = 'C';
                            elseif ($marks >= 50)  $grade = 'D';
                            else                   $grade = 'F';
                        }
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <span style="font-weight:600; color:#4f46e5;">
                                {{ $sub->assignment->course->title }}
                            </span>
                        </td>
                        <td>{{ $sub->assignment->title }}</td>
                        <td style="font-size:.82rem; color:#9ca3af;">
                            {{ $sub->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if($marks !== null)
                                <span class="marks-pill {{ $marks >= 70 ? 'marks-high' : ($marks >= 40 ? 'marks-mid' : 'marks-low') }}">
                                    {{ $marks }}/100
                                </span>
                            @else
                                <span class="marks-pill marks-none">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($marks !== null)
                                <span style="font-size:1.2rem; font-weight:800;
                                    color:{{ $marks >= 70 ? '#16a34a' : ($marks >= 50 ? '#ca8a04' : '#dc2626') }};">
                                    {{ $grade }}
                                </span>
                            @else
                                <span style="color:#9ca3af;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary --}}
        @php
            $gradedSubs = $submissions->whereNotNull('marks');
            $avg = $gradedSubs->count() ? round($gradedSubs->avg('marks'), 1) : null;
        @endphp
        @if($avg !== null)
        <div style="background:#f8f7ff; border-radius:10px; padding:16px; margin-top:16px; display:flex; gap:20px; flex-wrap:wrap;">
            <div style="text-align:center;">
                <div style="font-size:.78rem; color:#9ca3af;">Average Marks</div>
                <div style="font-size:1.6rem; font-weight:800; color:#4f46e5;">{{ $avg }}<span style="font-size:.9rem; color:#9ca3af;">/100</span></div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:.78rem; color:#9ca3af;">Total Submissions</div>
                <div style="font-size:1.6rem; font-weight:800; color:#1e1b4b;">{{ $submissions->count() }}</div>
            </div>
            <div style="text-align:center;">
                <div style="font-size:.78rem; color:#9ca3af;">Graded</div>
                <div style="font-size:1.6rem; font-weight:800; color:#16a34a;">{{ $gradedSubs->count() }}</div>
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
