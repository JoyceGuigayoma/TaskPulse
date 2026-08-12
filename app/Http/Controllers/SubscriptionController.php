<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Show the billing and subscription status page for a workspace.
     */
    public function index(Workspace $workspace)
    {
        // Authorize that user belongs to workspace
        $this->authorize('viewAny', [Workspace::class, $workspace]);

        return view('billing.index', [
            'workspace' => $workspace,
            'subscription' => $workspace->subscription('default'),
        ]);
    }

    /**
     * Generate a Stripe Checkout Session for Pro Plan.
     */
    public function checkout(Request $request, Workspace $workspace)
    {
        // Check if user is an admin of this workspace before allowing checkout
        $this->authorize('update', $workspace);

        // Price ID created in Stripe Dashboard (e.g., price_1Nxxx)
        $stripePriceId = config('services.stripe.pro_price_id', 'price_1ProPlanTestId123');

        return $workspace->newSubscription('default', $stripePriceId)
            ->checkout([
                'success_url' => route('workspaces.show', $workspace) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('billing.index', $workspace),
            ]);
    }

    /**
     * Manage or Cancel Subscription via Stripe Customer Portal.
     */
    public function portal(Workspace $workspace)
    {
        $this->authorize('update', $workspace);

        return $workspace->redirectToBillingPortal(route('billing.index', $workspace));
    }
}