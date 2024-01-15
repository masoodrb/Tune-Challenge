import React from 'react'
import { Avatar } from '../atoms/Avatar'
import ConversionsChart from '../atoms/ConversionsChart'

type Props = {
  user: any;
}

export function Card({ user }: Props) {

  const getConversionsDate = (user: any) => {
    // const { stats } = user;
    const { conversionsPerDay } = user;
    let sortedConversions = conversionsPerDay.sort((a: any, b: any) => new Date(a.date).getTime() - new Date(b.date).getTime());
    let firstLast = sortedConversions.slice(0, 1).concat(sortedConversions.slice(-1));
    const conversionsDates = firstLast.map((conversion: any) => {
      const date = new Date(conversion.date);
      const month = date.getMonth() + 1;
      const day = date.getDate();
      return `${month}/${day}`;
    });

    return `Conversions ${conversionsDates.join(' - ')}`;
  }
  return (
    <>
      <div key={user.id} className='bg-white rounded-sm p-4 shadow-md'>
        <span className="flex items-center">
          <div className="flex-none">
            <div className="w-10 h-10 rounded-full ltr:mr-3 rtl:ml-3 m-3">

              <Avatar imgUrl={user.avatar} name={user.name} />
            </div>
          </div>
          <div className="flex-1 text-start">
            <h4 className="text-2xl font-medium whitespace-nowrap">
              {user.name}
            </h4>
            <div className="text-md font-normal text-slate-600 dark:text-slate-400">
              {user.occupation}
            </div>
          </div>
        </span>
        <div className='grid grid-cols-10 gap-1'>
          <div className='col-span-7 bg-green'>
            <div>
              <ConversionsChart data={user.conversionsPerDay} />

            </div>
            <div>{getConversionsDate(user)}</div>
          </div>
          <div className='col-span-3 bg-green text-right'>
            <div>{user.stats.totalImpressions}</div>
            <div className='text-gray-500'>impressions</div>
            <div>{user.stats.totalConversions}</div>
            <div className='text-gray-500'>conversions</div>
            <div>{new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(user.stats.totalRevenue)}</div>
            <div className='text-gray-500'>revenue</div>
          </div>
        </div>
      </div>
    </>
  )
}
