#include "BTreeNode.h"

using namespace std;

/*
 * Read the content of the node from the page pid in the PageFile pf.
 * @param pid[IN] the PageId to read
 * @param pf[IN] PageFile to read from
 * @return 0 if successful. Return an error code if there is an error.
 */


// constructor to initialize buffer size
 BTLeafNode::BTLeafNode()
 {
 	memset(buffer,'\0',PageFile::PAGE_SIZE);
 	number_keys = 0;
 }

RC BTLeafNode::read(PageId pid, const PageFile& pf)
{ 
	return pf.read(pid,buffer);
}
    
/*
 * Write the content of the node to the page pid in the PageFile pf.
 * @param pid[IN] the PageId to write to
 * @param pf[IN] PageFile to write to
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTLeafNode::write(PageId pid, PageFile& pf)
{
	return pf.write(pid,buffer); 

 }

/*
 * Return the number of keys stored in the node.
 * @return the number of keys in the node
 */
int BTLeafNode::getKeyCount()
{
	// return number_keys;
	int count = 0;
	// 1 Record is (RecordID rid,int key)
	int size_record = sizeof(RecordId) + sizeof(int);
	for(int i=0;i<PageFile::PAGE_SIZE;)
	{
		if(buffer[i]=='\0')
			break;
		count++;
		i += size_record;
	}
	return count;
 }

/*
* Get max key count 
*/
int BTLeafNode::maxKeyCount()
{
	int size_page = PageFile::PAGE_SIZE;
	int size_record = sizeof(int) + sizeof(RecordId);
	return floor(size_page/size_record); 
 }
/*
 * Insert a (key, rid) pair to the node.
 * @param key[IN] the key to insert
 * @param rid[IN] the RecordId to insert
 * @return 0 if successful. Return an error code if the node is full.
 */
RC BTLeafNode::insert(int key, const RecordId& rid)
{ 
	int size_record = sizeof(int) + sizeof(RecordId);
	// insert node in sorted order
	int count = getKeyCount();
	// node full
	if(count >= maxKeyCount())
		return -1;
	// the buffer holds all the key-value pairs
	// insert new key in sorted order
	int eid;
	locate(key,eid);
	// must insert new data at eid position
	// copy data after eid to new node
	char * temp = new char[(count-eid)*size_record];
	memcpy(temp,buffer+eid*size_record,(count-eid)*size_record);
	// insert data into buffer
	memcpy(buffer+eid*size_record,&key,sizeof(int));
	memcpy(buffer+eid*size_record+sizeof(int),&rid,sizeof(RecordId));
	// append old data
	mempcpy(buffer+(eid+1)*size_record,temp,(count-eid)*size_record);
	// added new record
	number_keys++;
	return 0;
 }

/*
 * Insert the (key, rid) pair to the node
 * and split the node half and half with sibling.
 * The first key of the sibling node is returned in siblingKey.
 * @param key[IN] the key to insert.
 * @param rid[IN] the RecordId to insert.
 * @param sibling[IN] the sibling node to split with. This node MUST be EMPTY when this function is called.
 * @param siblingKey[OUT] the first key in the sibling node after split.
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTLeafNode::insertAndSplit(int key, const RecordId& rid, 
                              BTLeafNode& sibling, int& siblingKey)
{
	int size_record = sizeof(int) + sizeof(RecordId);
	// insert node in sorted order
	int count = getKeyCount();
	// split current node in half and keep 1 extra in left
	int halfcount = (count+1)/2;
	int halfsize = halfcount * size_record;
	// get next pid
	PageId nextpid = getNextNodePtr();
	// no overflow
	if(getKeyCount() < maxKeyCount())
		return -1;
	// check if sibling node is empty
	if(!sibling.getKeyCount()==0)
		return -1;
	// copy right half to sibling
	memcpy(sibling.buffer,buffer+halfsize,PageFile::PAGE_SIZE-halfsize-sizeof(PageId));
	// update no of keys
	sibling.number_keys = getKeyCount() - halfcount;
	// set next node ptr as nextptr of original node
	sibling.setNextNodePtr(getNextNodePtr());
	// clear left buffer
	fill(buffer+halfsize,buffer+PageFile::PAGE_SIZE-sizeof(PageId),'\0');
	number_keys = halfcount;
	// check where to insert new key
	int second_half_key;
	memcpy(&second_half_key,sibling.buffer,sizeof(int));
	if(siblingKey > second_half_key)
	{
		sibling.insert(key,rid);
	}
	else
	{
		insert(key,rid);
	}
	// copy sibling key
	memcpy(&siblingKey,sibling.buffer,sizeof(int));
	return 0;
 }

/**
 * If searchKey exists in the node, set eid to the index entry
 * with searchKey and return 0. If not, set eid to the index entry
 * immediately after the largest index key that is smaller than searchKey,
 * and return the error code RC_NO_SUCH_RECORD.
 * Remember that keys inside a B+tree node are always kept sorted.
 * @param searchKey[IN] the key to search for.
 * @param eid[OUT] the index entry number with searchKey or immediately
                   behind the largest key smaller than searchKey.
 * @return 0 if searchKey is found. Otherwise return an error code.
 */
RC BTLeafNode::locate(int searchKey, int& eid)
{ 
	int count_nodes = getKeyCount();
	int size_record = sizeof(int) + sizeof(RecordId);
	for(int i=0;i<count_nodes;++i)
	{
		// read entry
		int read_key;
		RecordId read_rid;
		readEntry(eid,read_key,read_rid);
		if(read_key >= searchKey)
		{
			eid = i;
			return 0;
		}
	}

	// couldnt find search key
	eid = getKeyCount();
	return -1;
 }

/*
 * Read the (key, rid) pair from the eid entry.
 * @param eid[IN] the entry number to read the (key, rid) pair from
 * @param key[OUT] the key from the entry
 * @param rid[OUT] the RecordId from the entry
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTLeafNode::readEntry(int eid, int& key, RecordId& rid)
{ 
	// read key at eid position
	if(eid > getKeyCount() || eid < 0)
		return -1;
	int size_record = sizeof(RecordId)+sizeof(key);
	memcpy(&key,buffer + eid*size_record,sizeof(int));	
	memcpy(&rid,buffer + eid*size_record+sizeof(int),sizeof(RecordId));	
	return 0;
 }

/*
 * Return the pid of the next sibling node.
 * @return the PageId of the next sibling node 
 */
PageId BTLeafNode::getNextNodePtr()
{ 
	PageId pid = 0;
	// pid is the first item of the record
	// buffer = key + RecordId(pid+eid)
	// go to end of buffer
	// check if sizeof(PageId)?
	memcpy(&pid,buffer+PageFile::PAGE_SIZE-sizeof(RecordId),sizeof(PageId));
	return pid;
 }

/*
 * Set the pid of the next sibling node.
 * @param pid[IN] the PageId of the next sibling node 
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTLeafNode::setNextNodePtr(PageId pid)
{ 
	// check if valid pid
	if(pid < 0)
		return RC_INVALID_PID;
	// set pid in buffer
	char * temp = buffer;
	// sizeof RecordId or PageId?
	memcpy(temp+PageFile::PAGE_SIZE-sizeof(RecordId),&pid,sizeof(PageId));
	return 0;
 }

BTNonLeafNode::BTNonLeafNode()
 {
 	memset(buffer,'\0',PageFile::PAGE_SIZE);
 	number_keys = 0;
 }


/*
 * Read the content of the node from the page pid in the PageFile pf.
 * @param pid[IN] the PageId to read
 * @param pf[IN] PageFile to read from
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTNonLeafNode::read(PageId pid, const PageFile& pf)
{ 
	return pf.read(pid,buffer);
	 }
    
/*
 * Write the content of the node to the page pid in the PageFile pf.
 * @param pid[IN] the PageId to write to
 * @param pf[IN] PageFile to write to
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTNonLeafNode::write(PageId pid, PageFile& pf)
{ 
	return pf.write(pid,buffer); 
	 }

/*
 * Return the number of keys stored in the node.
 * @return the number of keys in the node
 */
int BTNonLeafNode::getKeyCount()
{ 
	// return number_keys;
	int count = 0;
	// 1 Record is (RecordID rid,int key)
	int size_record = sizeof(PageId) + sizeof(int);
	for(int i=0;i<PageFile::PAGE_SIZE;)
	{
		if(buffer[i]=='\0')
			break;
		count++;
		i += size_record;
	}
	return count;
	return 0; 
}

int BTNonLeafNode::maxKeyCount()
{
	int size_page = PageFile::PAGE_SIZE;
	int size_record = sizeof(int) + sizeof(RecordId);
	return floor(size_page/size_record); 
 }
/*
 * Insert a (key, pid) pair to the node.
 * @param key[IN] the key to insert
 * @param pid[IN] the PageId to insert
 * @return 0 if successful. Return an error code if the node is full.
 */
RC BTNonLeafNode::insert(int key, PageId pid)
{ 
	int size_record = sizeof(int) + sizeof(PageId);
	// insert node in sorted order
	int count = getKeyCount();
	// node full
	if(count >= maxKeyCount())
		return -1;
	// the buffer holds all the key-value pairs
	// insert new key in sorted order
	int eid;
	locate(key,eid);
	// must insert new data at eid position
	// copy data after eid to new node
	char * temp = new char[(count-eid)*size_record];
	memcpy(temp,buffer+eid*size_record,(count-eid)*size_record);
	// insert data into buffer
	memcpy(buffer+eid*size_record,&key,sizeof(int));
	memcpy(buffer+eid*size_record+sizeof(int),&rid,sizeof(PageId));
	// append old data
	mempcpy(buffer+(eid+1)*size_record,temp,(count-eid)*size_record);
	// added new record
	number_keys++;
	return 0; 
}
RC BTNonLeafNode::locate(int searchKey, int& eid)
{ 
	int count_nodes = getKeyCount();
	int size_record = sizeof(int) + sizeof(RecordId);
	for(int i=0;i<count_nodes;++i)
	{
		// read entry
		int read_key;
		RecordId read_rid;
		readEntry(eid,read_key,read_rid);
		if(read_key >= searchKey)
		{
			eid = i;
			return 0;
		}
	}

	// couldnt find search key
	eid = getKeyCount();
	return -1;
 }

/*
 * Insert the (key, pid) pair to the node
 * and split the node half and half with sibling.
 * The middle key after the split is returned in midKey.
 * @param key[IN] the key to insert
 * @param pid[IN] the PageId to insert
 * @param sibling[IN] the sibling node to split with. This node MUST be empty when this function is called.
 * @param midKey[OUT] the key in the middle after the split. This key should be inserted to the parent node.
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTNonLeafNode::insertAndSplit(int key, PageId pid, BTNonLeafNode& sibling, int& midKey)
{ 
	int size_record = sizeof(int) + sizeof(RecordId);
	// insert node in sorted order
	int count = getKeyCount();
	// split current node in half and keep 1 extra in left
	int halfcount = (count+1)/2;
	int halfsize = halfcount * size_record;
	// get next pid
	PageId nextpid = getNextNodePtr();
	// no overflow
	if(getKeyCount() < maxKeyCount())
		return -1;
	// check if sibling node is empty
	if(!sibling.getKeyCount()==0)
		return -1;
	// copy right half to sibling
	memcpy(sibling.buffer,buffer+halfsize,PageFile::PAGE_SIZE-halfsize-sizeof(PageId));
	// update no of keys
	sibling.number_keys = getKeyCount() - halfcount;
	// set next node ptr as nextptr of original node
	sibling.setNextNodePtr(getNextNodePtr());
	// clear left buffer
	fill(buffer+halfsize,buffer+PageFile::PAGE_SIZE-sizeof(PageId),'\0');
	number_keys = halfcount;
	// check where to insert new key
	int second_half_key;
	memcpy(&second_half_key,sibling.buffer,sizeof(int));
	if(siblingKey > second_half_key)
	{
		sibling.insert(key,rid);
	}
	else
	{
		insert(key,rid);
	}
	// copy sibling key
	memcpy(&siblingKey,sibling.buffer,sizeof(int));
	return 0;
}

/*
 * Given the searchKey, find the child-node pointer to follow and
 * output it in pid.
 * @param searchKey[IN] the searchKey that is being looked up.
 * @param pid[OUT] the pointer to the child node to follow.
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTNonLeafNode::locateChildPtr(int searchKey, PageId& pid)
{
	int offset = sizeof(int)*2;
	char* ptr = &buffer[0]+sizeof(int)+sizeof(PageId);
	int c = 0;// for comparison
	//copy first key to compareKey for comparison. initial
	memcpy(&c, buffer+offset, sizeof(int));   
	// Keep searching for the child pid
    for (int x = 0; x < numKey; x++){
        if (searchKey < c){
            memcpy(&pid, ptr-sizeof(PageId), sizeof(PageId)); 
            return 0;
        }
        // If search key >= compareKey
        ptr += sizeRec;
        memcpy(&c, pointer, sizeof(int));
    }
     memcpy(&pid, ptr-sizeof(PageId), sizeof(int));
	return 0; 
}

/*
 * Initialize the root node with (pid1, key, pid2).
 * @param pid1[IN] the first PageId to insert
 * @param key[IN] the key that should be inserted between the two PageIds
 * @param pid2[IN] the PageId to insert behind the key
 * @return 0 if successful. Return an error code if there is an error.
 */
RC BTNonLeafNode::initializeRoot(PageId pid1, int key, PageId pid2)
{ 
	char* ptr = &buffer[0] + sizeof(int);
	memcpy(ptr, &pid1, sizeof(PageId)); 
	ptr += sizeof(PageId);
	memcpy(ptr, &key, sizeof(int));
	ptr += sizeof(int);
	memcpy(ptr, &pid2, sizeof(PageId));	
	ptr = &buffer[0];
	int count = 1;
	memcpy(ptr,&count,sizeof(int));
	for (int x = 0; x < 1; x++){
		int temp;
		memcpy(&temp, buffer+sizeof(int)*2+x*sizeRec, sizeof(int));
	}
	return 0; 
}
