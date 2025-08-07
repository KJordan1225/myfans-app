@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">Create Subscription</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">
 
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Create Subscription Product with Plans</h2>

    <form method="POST" action="{{ route('creator.subscription.store') }}">
        @csrf

        <!-- Product Name -->
        <div class="mb-4">
            <label for="name" class="block font-semibold">Product Name</label>
            <input type="text" name="plan_name" 
                id="plan_name" 
                class="w-full p-2 rounded" 
                style="border: 2px solid #6f42c1;"
                value="{{ old('plan_name') }}" 
                required>
        </div>

        <!-- Plan Inputs (Repeatable) -->
        <div id="plans-wrapper">
            <div class="plan-group p-4 rounded mb-4">
                <div class="mb-2">
                    <label class="block font-semibold">Amount (USD)</label>
                    <input type="number" step="0.01" 
                        name="prices[0][amount]" 
                        class="w-full p-2 rounded" 
                        style="border: 2px solid #6f42c1;"
                        required>
                </div>

                <div>
                    <label class="block font-semibold">Interval</label>
                    <select name="prices[0][interval]" 
                        class="w-full p-2 rounded" 
                        style="border: 2px solid #6f42c1;" 
                        required>
                        <option value="day">Day</option>
                        <option value="week">Week</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Add Plan Button -->
        <div>
            <button type="button" onclick="addPlan()"
                    class="mb-4 bg-gray-200 hover:bg-gray-300 text-sm px-3 py-1 rounded">
                + Add Another Plan
            </button>
        </div>
        
        <!-- Submit --> 
        <button type="submit" id="submit-button"
            class="btn text-white w-15 fw-semibold py-2 px-4 rounded"
            style="background-color: #6f42c1; border-color: #6f42c1;">
            Create Subscription
        </button>
    </form>
</div>
 
            </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<script>
let planIndex = 1;

function addPlan() {
    const wrapper = document.getElementById('plans-wrapper');

    const html = `
    <div class="plan-group p-4 rounded mb-4">
        <div class="mb-2">
            <label class="block font-semibold">Amount (USD)</label>
            <input type="number" step="0.01" name="prices[${planIndex}][amount]" class="w-full p-2 rounded" style="border: 2px solid #6f42c1;" required>
        </div>

        <div>
            <label class="block font-semibold">Interval</label>
            <select name="prices[${planIndex}][interval]" class="w-full p-2 rounded" style="border: 2px solid #6f42c1;" required>
                <option value="day">Day</option>
                <option value="week">Week</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
    </div>`;

    wrapper.insertAdjacentHTML('beforeend', html);
    planIndex++;
}
</script>
@endpush