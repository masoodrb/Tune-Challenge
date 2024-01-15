import { useEffect, useState } from 'react'

import { fetchGraphQLData } from '../api/graphql';

import LoadingSpinner from '../atoms/LoadingSpinner';
import { SortingOptions } from '../molecules/SortingOptions';
import { Card } from '../molecules/Card';
import { User } from '../types/dashboard';

const UsersGrid = () => {

  const [users, setUsers] = useState<User[]>([]);
  const [isLoading, setIsLoading] = useState(false);
  const [sortOptions, setSortOptions] = useState({
    field: 'name',
    direction: 'ASC',
  });

  useEffect(() => {
    const fetchUsers = async () => {
      setIsLoading(true);
      const { data } = await fetchGraphQLData(sortOptions);
      setUsers(data.users);
      setIsLoading(false);
    }
    fetchUsers();
  }, [sortOptions])

  const handleSort = (field: string, direction: string) => {
    setSortOptions({
      field,
      direction,
    });
  };


  return (
    <>
      <div className='flex justify-end'>
        <SortingOptions handleSort={handleSort} />
      </div>
      <div className='grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4'>
        {!isLoading && users.map((user, index) => (
          <Card user={user} />
        ))}
      </div>
      {isLoading && <LoadingSpinner />}

    </>
  )
}

export default UsersGrid