export type SortOptions = {
  field: string;
  direction: string;
};

export type Stats = {
  totalImpressions: number;
  totalConversions: number;
  totalRevenue: number;
};

export type ConversionsPerDay = {
  date: string;
  conversions: number;
};

export type User = {
  id: string;
  name: string;
  avatar: string;
  occupation: string;
  stats: Stats;
  conversionsPerDay: ConversionsPerDay[];
};