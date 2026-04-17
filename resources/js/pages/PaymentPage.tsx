// PaymentPage.tsx
import { useState } from "react";
import axios from "axios";
import { Button } from "@/components/ui/button";

interface Props {
  userId: number;
  onSuccess?: () => void;
}

function showToast(message: string) {
  const toast = document.createElement("div");
  toast.innerText = message;
  toast.className = "fixed bottom-5 right-5 bg-black text-white px-4 py-2 rounded shadow";
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

export default function PaymentPage({ onSuccess, userId }: Props) {
  const [amount, setAmount] = useState<string>("");
  const [loading, setLoading] = useState<boolean>(false);

  const handlePayment = async () => {
    setLoading(true);
    try {
      await axios.post(`/api/users/${userId}/purchases`, { amount: Number(amount) });
      showToast("Payment successful! 🎉");
      setAmount("");
      onSuccess && onSuccess();
    } catch (err) {
      console.error(err);
      showToast("Payment failed ❌");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="p-6 max-w-md mx-auto border rounded-2xl shadow">
      <h1 className="text-xl font-bold mb-4">Make a Payment</h1>

      <input
        type="number"
        placeholder="Enter amount"
        value={amount}
        onChange={(e) => setAmount(e.target.value)}
        className="w-full p-2 border rounded mb-4"
      />

      <Button onClick={handlePayment} disabled={loading}>
        {loading ? "Processing..." : "Pay"}
      </Button>
    </div>
  );
}