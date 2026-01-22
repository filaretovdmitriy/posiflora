import type { AxiosResponse } from "axios";

export const getErrorFromResponse = (response: AxiosResponse): string[] => {
  const unknownError =
    "Ошибка выполнения запроса. При повторном возникновении обратитесь в службу поддержки.";

  let errors = [unknownError];
  try {
    if (
      response &&
      response.data &&
      response.status !== undefined &&
      response.status >= 400
    ) {
      const responseData: any = response.data;
      if (Array.isArray(responseData)) {
        errors = responseData;
      } else if (response.data.errors && Array.isArray(response.data.errors)) {
        errors = response.data.errors;
      } else {
        errors = Object.entries(responseData)?.map(
          (x) => `Поле ${x[0]}: ${x[1]}`,
        ) ?? [unknownError];
      }
    } else {
      // here we can work with errors from catch block (catch (error <--))
      const rsp: any = response;
      const resp = rsp.response;

      if (
        resp &&
        resp.data &&
        resp.status !== undefined &&
        resp.status >= 400
      ) {
        const respData: any = resp.data;
        if (Array.isArray(respData)) {
          errors = respData;
        } else if (resp.data.errors && Array.isArray(resp.data.errors)) {
          errors = resp.data.errors;
        } else {
          errors = Object.entries(respData)?.map(
            (x) => `Поле ${x[0]}: ${x[1]}`,
          ) ?? [unknownError];
        }
      }
    }
  } catch {
    errors = [unknownError];
  }

  return errors;
};
