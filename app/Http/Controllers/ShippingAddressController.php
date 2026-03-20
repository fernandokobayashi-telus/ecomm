<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        if (!empty($data['is_default'])) {
            $request->user()->shippingAddresses()->update(['is_default' => false]);
        }

        $request->user()->shippingAddresses()->create($data);

        return redirect(route('dashboard') . '#addresses')->with('status', 'address-added');
    }

    public function update(Request $request, ShippingAddress $address): RedirectResponse
    {
        abort_if($address->user_id !== $request->user()->id, 403);

        $data = $request->validate($this->rules());

        if (!empty($data['is_default'])) {
            $request->user()->shippingAddresses()
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($data);

        return redirect(route('dashboard') . '#addresses')->with('status', 'address-updated');
    }

    public function destroy(ShippingAddress $address): RedirectResponse
    {
        abort_if($address->user_id !== auth()->id(), 403);

        $address->delete();

        return redirect(route('dashboard') . '#addresses')->with('status', 'address-deleted');
    }

    private function rules(): array
    {
        return [
            'label' => ['nullable', 'string', 'max:50'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'size:2'],
            'is_default' => ['boolean'],
        ];
    }
}
