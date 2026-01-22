import { useMutation, useQueryClient } from "@tanstack/react-query";
import { postTelegramConnectOnServer } from "../../../shared/api/endpoints/telegram";

export const usePostTelegramConnectOnServerMutation = () => {
    const queryClient = useQueryClient();
    return useMutation({
        mutationFn: postTelegramConnectOnServer,
        onSuccess: () => {},
        onError: () => {
            console.log('Проблемы с добавлением соединения');
        },
        onSettled: () => {
            queryClient.invalidateQueries({ queryKey: ['statusesKey'] });
        },
    });
};