import {
    type IMultipleResponse,
    type ISingleResponse,
    apiInstance,
} from '../apiInstance';



const TELEGRAM_PREFIX = 'telegram/';

export interface ITelegramStatusRequestDto{
    shopId: string
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


