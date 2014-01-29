def configServer():
  """
  Import configuration file and set parameters 
  """
  try:
    config = open(r"./server.conf","r+")
  except IOError,e:
    print e
    return 0
  configLines = []
  try:
    while True:
      configLines.append(config.next())
  except StopIteration:
    pass
  finally:
    config.close()
  configInfo = {}
  for line in configLines:
    if line[0] == "#" or line[0] == "\n":
      continue
    configLineArgumentList = line[:-1].split("=")
    key = configLineArgumentList[0]
    value = configLineArgumentList[1]
    configInfo.update({key:value})
  logging.info("Configuration done sucssesfully")
  return configInfo