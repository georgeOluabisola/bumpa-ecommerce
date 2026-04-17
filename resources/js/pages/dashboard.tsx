import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

import { Card, CardContent } from '@/components/ui/card';
import axios from 'axios';
import { motion } from 'framer-motion';
import { useEffect, useState } from 'react';
import PaymentPage from './PaymentPage';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface Achievement {
    id: number;
    name: string;
    achievements_required: number;
    created_at: string;
    updated_at: string;
    pivot?: any;
}

interface Badge {
    id: number;
    name: string;
    achievements_required: number;
    created_at: string;
    updated_at: string;
    pivot?: any;
}

interface AchievementResponse {
    unlocked_achievements: string[];
    next_available_achievements: string[];
    current_badge: Badge | null;
    next_badge: string | null;
    total_purchase: number | null;
    remaining_to_unlock_next_badge: number;
}

export default function Dashboard({ user }) {
    const [data, setData] = useState<AchievementResponse | null>(null);

    const fetchData = () => {
        axios
            .get(`/api/users/${user.id}/achievements`)
            .then((res) => setData(res.data))
            .catch((err) => console.error(err));
    };

    useEffect(() => {
        fetchData();
    }, []);

    if (!data) return <div className="p-6">Loading...</div>;

    const total = data.unlocked_achievements.length + data.remaining_to_unlock_next_badge;
    const progress = total === 0 ? 0 : (data.unlocked_achievements.length / total) * 100;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="grid gap-6 p-6">
                <h1 className="text-2xl font-bold">Customer Dashboard</h1>

                <Card>
                    <CardContent className="p-4">
                        <h2 className="text-lg font-semibold">Total Purchase</h2>
                        <p className="text-xl">{data.total_purchase || '0'}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent className="p-4">
                        <h2 className="text-lg font-semibold">Current Badge</h2>
                        <p className="text-xl">{data.current_badge?.name || 'No Badge Yet'}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent className="p-4">
                        <h2 className="text-lg font-semibold">Progress to Next Badge</h2>
                        <motion.div
                            initial={{ width: 0 }}
                            animate={{ width: `${progress}%` }}
                            transition={{ duration: 1 }}
                            className="h-3 rounded bg-blue-500"
                        />
                        <p className="mt-2 text-sm">
                            {data.remaining_to_unlock_next_badge} more achievement to unlock {data.next_badge} Badge
                        </p>
                    </CardContent>
                </Card>

                <div className="grid gap-4 md:grid-cols-2">
                    <Card>
                        <CardContent className="p-4">
                            <h2 className="font-semibold">Unlocked Achievements</h2>
                            {data.unlocked_achievements.length === 0 ? (
                                <p className="text-gray-500">No unlocked achievements yet</p>
                            ) : (
                                <ul className="list-disc pl-5">
                                    {data.unlocked_achievements.map((a, i) => (
                                        <li key={i}>{a}</li>
                                    ))}
                                </ul>
                            )}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-4">
                            <h2 className="font-semibold">Next Achievements</h2>
                            {data.next_available_achievements.length === 0 ? (
                                <p className="text-gray-500">No achievements available</p>
                            ) : (
                                <ul className="list-disc pl-5">
                                    {[...data.next_available_achievements]
                                        .sort()
                                        .reverse()
                                        .map((a, i) => (
                                            <li key={i}>{a}</li>
                                        ))}
                                </ul>
                            )}
                        </CardContent>
                    </Card>
                </div>

                <PaymentPage onSuccess={fetchData} userId={1} />
            </div>
        </AppLayout>
    );
}
