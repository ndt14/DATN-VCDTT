export const pause = (ms: any) => new Promise((resolve) => setTimeout(resolve, ms));

export function formatNumber(number: string | number): string {
    return Number(number).toLocaleString();
  }
  
  export function cx(
    ...classNames: Array<string | number | boolean | undefined | null>
  ) {
    return classNames.filter(Boolean).join(' ');
  }