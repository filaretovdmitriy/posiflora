import { useState } from "react";
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
            
            {shopId ? <><Connect shopId={shopId}/><Statuses  shopId={shopId} /></>: <>Неверный shopId</> }
            

        </>
    )
}

export default TelegramGrowthPage