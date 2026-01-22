import { useQuery } from "@tanstack/react-query";
import { getTelegramStatusFromServer, type ITelegramStatusRequestDto } from "../../../shared/api/endpoints/telegram";

export const useGetTelegramStatusFromServerQuery = ({shopId}: ITelegramStatusRequestDto) =>
    useQuery({
        queryFn: () =>getTelegramStatusFromServer({shopId}),
        queryKey: ['statusesKey'],
    });