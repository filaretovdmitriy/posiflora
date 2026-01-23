
import { useGetTelegramStatusFromServerQuery } from "./model/queries";

interface IStatusesProps {
    shopId: string
}

const Statuses = ({shopId}: IStatusesProps) => {
    const { data, isSuccess } = useGetTelegramStatusFromServerQuery({shopId});
    return (
        <div>
            <h1>Статусы</h1>
            {isSuccess && <div>
                <p>enabled: {data?.data?.enabled ? "true" : "false"}</p>
                <p>chatId: {data?.data?.chatId}</p>
                <p>lastSentAt: {data?.data?.lastSentAt}</p>
                <p>sentCount: {data?.data?.sentCount}</p>
                <p>failedCount: {data?.data?.failedCount}</p>
                </div>}
        </div>
    )
}

export default Statuses


