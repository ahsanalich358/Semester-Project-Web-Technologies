@extends('layouts.app')
@section('title', 'AI Assistant')
@section('page-title', 'AI Study Assistant')

@section('content')

{{-- AI Header --}}
<div class="ai-box">
    <div class="d-flex align-items-center gap-3 mb-3">
        <div style="width:52px; height:52px; background:rgba(255,255,255,.15); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.6rem;">
            🤖
        </div>
        <div>
            <h4 style="margin:0;">AI Study Assistant</h4>
            <p style="margin:0;">Powered by Google Gemini — Koi bhi sawal poochein!</p>
        </div>
    </div>
    <p style="color:#a5b4fc; font-size:.85rem; margin:0;">
        ✅ Concept samjho &nbsp;|&nbsp; ✅ Sawal ka jawab pao &nbsp;|&nbsp; ✅ Urdu ya English mein poochein
    </p>
</div>

{{-- Error --}}
@if($errors->any())
    <div class="alert-error-custom">
        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
    </div>
@endif

{{-- Answer box --}}
@if(session('ai_answer'))
<div class="card-box mb-4">
    <div style="margin-bottom:12px;">
        <span style="background:#ede9fe; color:#5b21b6; padding:4px 14px; border-radius:20px; font-size:.8rem; font-weight:700;">
            <i class="fas fa-user"></i> Aapka Sawal:
        </span>
        <p style="margin-top:8px; color:#1e1b4b; font-weight:600; font-size:.92rem;">
            {{ session('ai_question') }}
        </p>
    </div>
    <div style="margin-bottom:8px;">
        <span style="background:#dcfce7; color:#16a34a; padding:4px 14px; border-radius:20px; font-size:.8rem; font-weight:700;">
            🤖 AI Ka Jawab:
        </span>
    </div>
    <div class="ai-answer-box">{{ session('ai_answer') }}</div>
</div>
@endif

{{-- Ask form --}}
<div class="card-box">
    <h5><i class="fas fa-comment-dots"></i> Apna Sawal Likhein</h5>
    <form method="POST" action="{{ route('student.ai.ask') }}">
        @csrf
        <div class="mb-3">
            <textarea name="question" class="form-control" rows="4"
                      placeholder="Yahan apna sawal likhein... Jaise: 'Newton ka pehla qanoon kya hai?' ya 'Photosynthesis explain karo'"
                      required>{{ old('question') }}</textarea>
            <div style="font-size:.78rem; color:#9ca3af; margin-top:4px;">Max 1000 characters</div>
        </div>
        <button type="submit" class="btn-primary-custom" id="askBtn">
            <i class="fas fa-paper-plane"></i> AI Se Poochein
        </button>
    </form>
</div>

{{-- Example questions --}}
<div class="card-box">
    <h5><i class="fas fa-lightbulb"></i> Example Sawal</h5>
    <div class="row g-2">
        @foreach([
            'Gravity kya hoti hai simple mein samjhao?',
            'Photosynthesis ka process explain karo.',
            'Pakistan ka capital kya hai aur kyun?',
            'Algebra mein quadratic equation kya hoti hai?',
            'Water cycle ko step by step samjhao.',
            'DNA aur RNA mein kya farq hai?',
        ] as $q)
        <div class="col-md-6">
            <button onclick="document.querySelector('textarea[name=question]').value = '{{ $q }}'"
                    style="background:#f8f7ff; border:1.5px solid #ede9fe; color:#5b21b6;
                           padding:10px 14px; border-radius:9px; width:100%;
                           text-align:left; font-size:.83rem; cursor:pointer; transition:all .15s;"
                    onmouseover="this.style.background='#ede9fe'"
                    onmouseout="this.style.background='#f8f7ff'">
                <i class="fas fa-arrow-right" style="font-size:.75rem;"></i> {{ $q }}
            </button>
        </div>
        @endforeach
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function() {
    const btn = document.getElementById('askBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> AI Soch raha hai...';
    btn.disabled = true;
});
</script>
@endsection
