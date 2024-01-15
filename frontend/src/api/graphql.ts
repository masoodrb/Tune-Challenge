import { SortOptions } from "../types/dashboard";

export const fetchGraphQLData = async (sortOptions: SortOptions) => {
  const response = await fetch(`${process.env.REACT_APP_BASE_URL}/graphql`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      query: `
      query {
        users(sort: { field: "${sortOptions.field}", direction: ${sortOptions.direction} }) {
          id
          name
          avatar
          occupation
          stats {
            totalImpressions
            totalConversions
            totalRevenue
          }
          conversionsPerDay {
            date
            conversions
          }
        }
      }
      `,
    }),
  });

  if (!response.ok) {
    throw new Error('Network response was not ok');
  }

  return response.json();
};