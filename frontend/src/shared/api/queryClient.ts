import { MutationCache, QueryCache, QueryClient } from "@tanstack/react-query";
import type { AxiosError, AxiosResponse } from "axios";


import { getErrorFromResponse } from "./Queries";

export const queryClient = new QueryClient({
  queryCache: new QueryCache({
    onError(error, query) {
      const axiosError = error as AxiosError;
      const errorDetails = getErrorFromResponse(
        axiosError.response as AxiosResponse,
      );

      const errorMessage = errorDetails
        .map((d: any) => {
          let message = "";

          if (typeof d === "string") {
            return d;
          }

          if (d !== null && typeof d === "object") {
            Object.keys(d).forEach((key) => {
              if (d[key] && typeof d[key] === "string") {
                message += `${key}: ${d[key]} `;
              }
            });
          }

          return message;
        })
        .join(", ");

      if (errorMessage.length > 0) {
        console.log(errorMessage);
      } else {
          console.log(
          "Ошибка выполнения запроса. При повторном возникновении обратитесь в службу поддержки.",
        );
      }
    },
  }),
  mutationCache: new MutationCache({
    onError(error, _) {
      const axiosError = error as AxiosError;
      const errorDetails = getErrorFromResponse(
        axiosError.response as AxiosResponse,
      );

      const errorMessage = errorDetails
        .map((d: any) => {
          let message = "";

          if (typeof d === "string") {
            return d;
          }

          if (d !== null && typeof d === "object") {
            Object.keys(d).forEach((key) => {
              if (d[key] && typeof d[key] === "string") {
                message += `${key}: ${d[key]} `;
              }
            });
          }

          return message;
        })
        .join(", ");

      if (errorMessage.length > 0) {
          console.log("Event has been created.");
      } else {
          console.log("Ошибка выполнения запроса. При повторном возникновении обратитесь в службу поддержки.");
      }
    },
  }),
  defaultOptions: {
    queries: {
      refetchOnWindowFocus: false,
      staleTime: 5 * 60 * 1000,
    },
  },
});
