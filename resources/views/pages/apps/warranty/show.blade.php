<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Warranty Receive</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .logo {
      width: 170px;
      display: block;
    }

    .warranty {
      margin: 20px 0;
      font-size: 13px;
      font-style: italic;
    }
    .font-semibold{
      font-size: 12px;
    }

    /* Hide print button when printing */
    @media print {
      .no-print {
        display: none !important;
      }
      body {
        background: #fff !important;
      }
      .shadow-md {
        box-shadow: none !important;
      }
      #body-part {
        box-shadow: none !important;
        padding: 0 !important;
        border: 0 !important;
      }
    }
  </style>
</head>
<body class="p-10 bg-gray-100 text-gray-800">

  <div class="bg-white p-5 rounded-lg max-w-4xl mx-auto border border-gray-300" id="body-part">
    <!-- Header -->
    <div class="flex justify-between items-start mb-4 ">
      <div>
        @php
          $company = \App\Models\Setting::first();
        @endphp
        @if(!is_null($company))
          <img src="{{ asset(config('app.logo')) }}" class="logo">
        @endif
        <div class="text-sm text-gray-500">{{ $company->address }}</div>
      </div>
      <div class="text-sm text-gray-600 space-y-1 w-60">
        <div class="flex justify-between"><span class="font-semibold">Phone:</span> <span>{{ $company->number1 ?? '017XXXXXXXX' }}</span></div>
        <div class="flex justify-between"><span class="font-semibold">Email:</span> <span>{{ $company->email ?? 'info@abctraders.com' }}</span></div>
      </div>
    </div>

    <div class="text-center text-2xl font-bold py-2" style="border-top: 1px solid #e9e9e9;">

    </div>

    <!-- Customer Info -->
    <div class="grid grid-cols-2 gap-y-0 gap-x-6 text-sm leading-6">
      <div><span class="font-semibold">Order No:</span> {{ $data->order_id ?? '' }}</div>
      <div><span class="font-semibold">Customer Name:</span> {{ $data->client_name }}</div>
      <div><span class="font-semibold">Received By:</span> {{ $data->recive_by }}</div>
      <div><span class="font-semibold">Mobile No:</span> {{ $data->mobile }}</div>

      @if( $data->email )
        <div><span class="font-semibold">Email:</span> {{ $data->email ?? '' }}</div>
      @endif
      @if( $data->date_of )
        <div><span class="font-semibold">Received Date:</span> {{ Carbon\Carbon::parse($data->date_of)->format('d M, Y') ?? '' }}</div>
      @endif
    </div>

    <!-- Product Info -->
    <div class="border border-gray-300 p-4 mt-4 rounded-md">
      <h3 class="text-sm font-bold text-gray-800 mb-2">Product Information</h3>
      <div class="space-y-2 text-sm">
        @forelse ($data->productInfo as $product)
          <div class="p-3 border border-gray-300 rounded-md bg-gray-50">
            <div><span class="font-semibold">Product Name:</span> {{ $product->product_name }}</div>
            <div><span class="font-semibold">Model:</span> {{ $product->model }}</div>
            <div><span class="font-semibold">Serial No:</span> {{ $product->serial_no }}</div>
            <div><span class="font-semibold">Remarks:</span> {{ $product->remarks ?? 'N/A' }}</div>
            @if(!is_null($product->problem))
                <div><span class="font-semibold">Product Problem:</span> {{ $product->problem ?? 'N/A' }}</div>
            @endif
            @if(!is_null($product->change))
                <div><span class="font-semibold">Product Change:</span> {{ $product->change ?? 'N/A' }}</div>
            @endif
          </div>
        @empty
          <p class="text-gray-500 italic">No product information found.</p>
        @endforelse
      </div>
    </div>

    <!-- Signatures -->
    <div class="flex justify-between mt-20 gap-20">
      <div class="w-1/2 text-center">
        <div class="border-t border-gray-600 pt-2">Customer's Signature</div>
      </div>
      <div class="w-1/2 text-center">
        <div class="border-t border-gray-600 pt-2">Authorized Signature</div>
      </div>
    </div>

    <div class="warranty">
      {!! App\Models\PagesContent::value('warranty_text') !!}
    </div>

    <!-- Print Button -->
    <div class="flex justify-between items-center mt-7 ">
        @php
          $fbLink = \App\Models\Setting::value('facebook');
        @endphp
        @if($fbLink)
        <div style="font-size: 12px;">
          Facebook: {{ $fbLink }}
          &nbsp;&nbsp;
          Website: https://srlaptopbd.com/
        </div>
        @endif
      <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow no-print">
        🖨️ Print
      </button>
    </div>
  </div>
</body>
</html>
