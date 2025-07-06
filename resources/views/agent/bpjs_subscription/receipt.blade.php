{{ json_encode($bpjs) }}
{{ json_encode($form_input) }}
{{ json_encode($transaction) }}

<h1>Transaction Successful</h1>

<em>{{ $transaction->created_at }}</em>

{{-- {{ var_dump($transaction) }} --}}
