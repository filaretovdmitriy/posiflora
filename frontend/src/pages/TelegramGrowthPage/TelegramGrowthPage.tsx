import { useParams } from "react-router-dom";
import Connect from "../../features/Connect/Connect";
import Statuses from "../../features/Statuses/Statuses";

type RouteParams = {
  shopId: string;
};

const TelegramGrowthPage = () => {
    const { shopId } = useParams<RouteParams>();

    return (
        <>
            {shopId ? <>
                <Connect shopId={shopId}/>
                <Statuses  shopId={shopId} />
                <p>chat_id можно узнать с божьей помощью или зайдя по адресу https://api.telegram.org/bot[Токен вашего бота]/getUpdates</p>
                </>
                : 
                <><div>Неверный shopId</div></> }
        </>
    )
}

export default TelegramGrowthPage