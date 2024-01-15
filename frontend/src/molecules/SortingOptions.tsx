import React, { useEffect, useState } from 'react'
import { FaSortAmountDownAlt } from 'react-icons/fa';

type Props = {
  handleSort: (field: string, direction: string) => void;
}

export function SortingOptions(props: Props) {
  const [dropdownOpen, setDropDownOpen] = useState(false);
  const dropdownRef = React.useRef<HTMLButtonElement>(null);

  useEffect(() => {
    function handleClickOutside(event: MouseEvent) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target as Node)) {
        setDropDownOpen(false);
      }
    }

    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, []);

  const handleSort = (field: string, direction: string) => {
    setDropDownOpen(false);
    props.handleSort(field, direction);
    
  }

  const onSortingOptionsClick = (e: React.MouseEvent<HTMLOrSVGElement, MouseEvent>) => {
    e.preventDefault();
      setDropDownOpen(!dropdownOpen);
  }

  return (
    <>
      <span ref={dropdownRef} className="items-center">
        <span className='flex flex-start mb-2'>Sorting Options <FaSortAmountDownAlt onClick={onSortingOptionsClick} className="cursor-pointer mx-1 h-6 w-6" /></span>
        {dropdownOpen && (
          <div className="cursor-pointer absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white text-black z-50">
            <div className="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
              <div className="w-full text-center block px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('name', 'ASC')}>Name - ASC</div>
              <div className="w-full text-center block px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('name', 'DESC')}>Name - DESC</div>
              <div className="w-full text-center block  px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('stats.totalImpressions', 'ASC')}>Impressions - ASC</div>
              <div className="w-full text-center block  px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('stats.totalImpressions', 'DESC')}>Impressions - DESC</div>
              <div className="w-full text-center block  px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('stats.totalConversions', 'ASC')}>Conversions - ASC</div>
              <div className="w-full text-center block  px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('stats.totalConversions', 'DESC')}>Conversions - DESC</div>
              <div className="w-full text-center block  px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('stats.totalRevenue', 'ASC')}>Revenue - ASC</div>
              <div className="w-full text-center block  px-4 py-2 text-sm hover:bg-gray-400 hover:text-white" onClick={() => handleSort('stats.totalRevenue', 'DESC')}>Revenue - DESC</div>
            </div>
          </div>
        )}
      </span>
    </>
  )
}
