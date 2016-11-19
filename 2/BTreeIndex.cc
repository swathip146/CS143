/*
 * Copyright (C) 2008 by The Regents of the University of California
 * Redistribution of this file is permitted under the terms of the GNU
 * Public License (GPL).
 *
 * @author Junghoo "John" Cho <cho AT cs.ucla.edu>
 * @date 3/24/2008
 */
 
#include "BTreeIndex.h"
#include "BTreeNode.h"

using namespace std;

/*
 * BTreeIndex constructor
 */
BTreeIndex::BTreeIndex()
{
    rootPid = -1;
    height = 0;
    std::fill(buffer, buffer + PageFile::PAGE_SIZE, 0);
}

/*
 * Open the index file in read or write mode.
 * Under 'w' mode, the index file should be created if it does not exist.
 * @param indexname[IN] the name of the index file
 * @param mode[IN] 'r' for read, 'w' for write
 * @return error code. 0 if no error
 */
RC BTreeIndex::open(const string& indexname, char mode)
{
    return 0;
}

/*
 * Close the index file.
 * @return error code. 0 if no error
 */
RC BTreeIndex::close()
{
    return 0;
}

/*
 * Insert (key, RecordId) pair to the index.
 * @param key[IN] the key for the value inserted into the index
 * @param rid[IN] the RecordId for the record being inserted into the index
 * @return error code. 0 if no error
 */
RC BTreeIndex::insert(int key, const RecordId& rid)
{
    return 0;
}

/**
 * Run the standard B+Tree key search algorithm and identify the
 * leaf node where searchKey may exist. If an index entry with
 * searchKey exists in the leaf node, set IndexCursor to its location
 * (i.e., IndexCursor.pid = PageId of the leaf node, and
 * IndexCursor.eid = the searchKey index entry number.) and return 0.
 * If not, set IndexCursor.pid = PageId of the leaf node and
 * IndexCursor.eid = the index entry immediately after the largest
 * index key that is smaller than searchKey, and return the error
 * code RC_NO_SUCH_RECORD.
 * Using the returned "IndexCursor", you will have to call readForward()
 * to retrieve the actual (key, rid) pair from the index.
 * @param key[IN] the key to find
 * @param cursor[OUT] the cursor pointing to the index entry with
 *                    searchKey or immediately behind the largest key
 *                    smaller than searchKey.
 * @return 0 if searchKey is found. Othewise an error code
 */
RC BTreeIndex::locate(int searchKey, IndexCursor& cursor)
{
	RC rc;	
	BTNonLeafNode nleaf;
	BTLeafNode leaf;
	int eid;
	int cht=1;
	PageID nextPid = rootPid;
	while(cht!=height)
	{
		rc=nleaf.read(nextPid,pf);
		if(rc!=0)
			return rc;
		rc=leaf.locateChildPtr(searchKey,nextPid);
		if(rc!=0)
			return rc;
		cht++;
	}
	rc=leaf.read(nextPid,pf);
	if(rc!=0)
		return rc;
	rc=leaf.locate(searchKey,eid);
	if(rc!=0)
		return rc;
	cursor.eid = eid;
	cursor.pid = nextPid;
    return 0;
    //return locateUtil(searchKey,cursor,1,rootPid)
}
// RC BTreeIndex::locateUtil(int searchKey, IndexCursor& cursor, int cht, PageId& nextPid)
// {

// }

/*
 * Read the (key, rid) pair at the location specified by the index cursor,
 * and move foward the cursor to the next entry.
 * @param cursor[IN/OUT] the cursor pointing to an leaf-node index entry in the b+tree
 * @param key[OUT] the key stored at the index cursor location.
 * @param rid[OUT] the RecordId stored at the index cursor location.
 * @return error code. 0 if no error
 */
RC BTreeIndex::readForward(IndexCursor& cursor, int& key, RecordId& rid)
{
	RC rc;
	rc=leaf.read(cursor.pid,pf);
	rc=leaf.readEntry(cursor.eid,key,rid);
	if((cursor.eid+1)>=leaf.getKeyCount())
	{
		cursor.eid=0;
		cursor.pid=leaf.getNextNodePtr();
	}
	else
	{
		cursor.eid++;
	}
    return 0;
}