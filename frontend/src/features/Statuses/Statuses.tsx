
import { useGetAlbumsFromServerQuery } from "./model/queries";

interface IStatusesProps {
    shopId: string
}

const Statuses = ({shopId}: IStatusesProps) => {
    const { data, isSuccess } = useGetAlbumsFromServerQuery({shopId});
    return (
        <div>
            <h1>Статусы</h1>
            {isSuccess && <div>{JSON.stringify(data)}</div>}
        </div>
    )
}

export default Statuses