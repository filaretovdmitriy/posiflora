import {
    type IMultipleResponse,
    type ISingleResponse,
    apiInstance,
} from '../apiInstance';



const TELEGRAM_PREFIX = 'telegram/';

export interface ITelegramStatusRequestDto{
    shopId: string
}

export interface ITelegramConnectRequestDto{
    shopId: string;
    botToken: string;
    chatId: string;
    enabled: boolean;
}

interface ITelegramStatusResponse {
    enabled: string,
    chatId: string;
    lastSentAt: string;
    sentCount: string;
    failedCount: string;
}





export const getTelegramStatusFromServer = (
    {shopId}: ITelegramStatusRequestDto,
): Promise<ISingleResponse<string>> => {
    return apiInstance.get(`${shopId}/${TELEGRAM_PREFIX}status`);
};

export const postTelegramConnectOnServer = (
    {shopId, botToken, chatId, enabled }: ITelegramConnectRequestDto,
): Promise<ISingleResponse<string>> => {
    return apiInstance.post(`${shopId}/${TELEGRAM_PREFIX}connect`, {botToken, chatId, enabled});
};




